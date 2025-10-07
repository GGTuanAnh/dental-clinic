<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Support\Carbon;

class AppointmentAdminController extends Controller
{
	use AuthorizesRequests;
	public function index(Request $request)
	{
		$this->authorize('viewAny', Appointment::class);
		$query = Appointment::with(['patient','service','doctor'])->orderByDesc('appointment_at');

		$user = $request->user();
		if($user->isDoctor()){
			// Map user -> doctor profile
			$doctorProfile = $user->doctor; // relation hasOne
			if($doctorProfile){
				$query->where('doctor_id', $doctorProfile->id);
			}
		}

		if ($status = $request->string('status')->toString()) {
			$query->where('status', $status);
		}
		if ($doctorId = $request->integer('doctor_id')) {
			$query->where('doctor_id', $doctorId);
		}
		if ($serviceId = $request->integer('service_id')) {
			$query->where('service_id', $serviceId);
		}
		if ($from = $request->string('from')->toString()) {
			$query->whereDate('appointment_at', '>=', $from);
		}
		if ($to = $request->string('to')->toString()) {
			$query->whereDate('appointment_at', '<=', $to);
		}
		if ($s = $request->string('q')->toString()) {
			$query->whereHas('patient', function($q) use ($s){
				$q->where('name','like',"%$s%")
				  ->orWhere('phone','like',"%$s%");
			});
		}

		$appointments = $query->paginate(15)->withQueryString();
		if($user->isDoctor()){
			\App\Support\AuditLogger::log('appointments.view.doctor', null, ['doctor_user_id'=>$user->id,'count'=>$appointments->count()]);
		}
		$doctors = $user->isDoctor() ? collect([]) : Doctor::orderBy('name')->get();
		$services = Service::orderBy('name')->get();

		return view('admin.appointments.index', compact('appointments','doctors','services'));
	}

	public function update(Request $request, int $id)
	{
		$appt = Appointment::findOrFail($id);
		$this->authorize('update', $appt);
		$data = $request->validate([
			'status' => 'nullable|string|in:pending,confirmed,completed,cancelled',
			'doctor_id' => 'nullable|integer|exists:doctors,id',
			'total_amount' => 'nullable|numeric|min:0',
			'paid' => 'nullable|boolean',
			'follow_up_at' => 'nullable|date',
			'note' => 'nullable|string',
		]);

		if (array_key_exists('status',$data)) $appt->status = $data['status'];
		if (array_key_exists('doctor_id',$data)) $appt->doctor_id = $data['doctor_id'];
		if (array_key_exists('total_amount',$data)) $appt->total_amount = $data['total_amount'];
		if (array_key_exists('note',$data)) $appt->note = $data['note'];
		if (array_key_exists('follow_up_at',$data)) $appt->follow_up_at = $data['follow_up_at'];

		if ($request->has('paid')) {
			$appt->paid_at = $data['paid'] ? now() : null;
		}

		$appt->save();
		\App\Support\AuditLogger::log('appointment.updated', $appt, [
			'changed' => array_keys($data)
		]);

		return back()->with('success', 'Đã cập nhật lịch hẹn.');
	}
}

