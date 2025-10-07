<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Service;
use App\Models\Patient;
use App\Models\Appointment;
use App\Events\BookingCreated;

class BookingController extends Controller
{
    public function showForm()
    {
        $services = Service::all();
        return view('booking.form', compact('services'));
    }

    public function storePublic(Request $request)
    {
        // Honeypot check: if hidden field is filled, drop silently
        if($request->filled('company')){
            return back()->with('success', 'Đặt lịch thành công. Chúng tôi sẽ liên hệ xác nhận.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'appointment_at' => 'required|date|after:now',
            'note' => 'nullable|string',
        ]);

        $patient = Patient::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name' => $validated['name']]
        );

        $appointmentTime = Carbon::parse($validated['appointment_at']);
        $doctorId = 1; // doctor duy nhất phụ trách lịch hẹn công khai

        $hasConflict = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('appointment_at', [
                $appointmentTime->copy()->subMinutes(29),
                $appointmentTime->copy()->addMinutes(29),
            ])->exists();

        if ($hasConflict) {
            return back()
                ->withErrors(['appointment_at' => 'Khung giờ này đã có lịch hẹn. Vui lòng chọn thời gian khác.'])
                ->withInput();
        }

        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $validated['service_id'],
            'doctor_id' => $doctorId,
            'appointment_at' => $appointmentTime,
            'status' => 'pending',
            'note' => $validated['note'] ?? null,
        ]);

        event(new BookingCreated($appt));

        return back()->with('success', 'Đặt lịch thành công. Chúng tôi sẽ liên hệ xác nhận.');
    }
}
