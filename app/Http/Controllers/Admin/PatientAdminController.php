<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientNote;

class PatientAdminController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Patient::class);
        $q = Patient::query();
        if ($s = $request->string('q')->toString()) {
            $q->where(function($qq) use ($s){
                $qq->where('name','like',"%$s%")
                   ->orWhere('phone','like',"%$s%");
            });
        }
        $patients = $q->orderByDesc('id')->paginate(15)->withQueryString();
        return view('admin.patients.index', compact('patients'));
    }

    public function show(int $id)
    {
        $patient = Patient::with(['appointments.service','appointments.doctor','notes' => function($q){ $q->orderByDesc('id'); }])->findOrFail($id);
        $this->authorize('view', $patient);
        return view('admin.patients.show', compact('patient'));
    }

    public function addNote(Request $request, int $id)
    {
        $patient = Patient::findOrFail($id);
        $this->authorize('addNote', $patient);
        $data = $request->validate(['note' => 'required|string']);
        $note = PatientNote::create(['patient_id'=>$patient->id, 'note'=>$data['note']]);
        \App\Support\AuditLogger::log('patient.note.added', $patient, ['note_id'=>$note->id]);
        return back()->with('success','Đã thêm ghi chú.');
    }
}
