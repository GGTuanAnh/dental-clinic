<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientAdminController extends BaseAdminController
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
        
        return $this->renderView('admin.patients.index', compact('patients'), 'Hồ sơ bệnh nhân');
    }

    public function show(int $id)
    {
        $patient = Patient::with(['appointments.service','appointments.doctor'])->findOrFail($id);
        $this->authorize('view', $patient);
        
        return $this->renderView('admin.patients.show', compact('patient'), 'Chi tiết bệnh nhân: ' . $patient->name);
    }

    // Patient notes feature removed as PatientNote model doesn't exist
    // If needed in future, create PatientNote model and migration first
}
