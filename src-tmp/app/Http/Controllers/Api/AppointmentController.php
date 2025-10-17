<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period');
        $query = Appointment::with(['patient','service','doctor'])->orderBy('appointment_at', 'desc');

        if ($period) {
            $now = now();
            switch ($period) {
                case '7days': $from = $now->subDays(7); break;
                case '1month': $from = $now->subMonth(); break;
                case '3months': $from = $now->subMonths(3); break;
                case '6months': $from = $now->subMonths(6); break;
                case '1year': $from = $now->subYear(); break;
                case 'today': $from = now()->startOfDay(); break;
                default: $from = null;
            }
            if (isset($from)) {
                $query->where('appointment_at', '>=', $from);
            }
        }

        $perPage = (int) $request->query('per_page', 20);
        $appts = $query->paginate($perPage)->withQueryString();

        return response()->json($appts);
    }

    public function show($id)
    {
        $appt = Appointment::with(['patient','service','doctor'])->findOrFail($id);
        return response()->json($appt);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'service_id' => 'required|exists:services,id',
            'appointment_at' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $patient = Patient::firstOrCreate(
            ['phone' => $data['phone']],
            ['name' => $data['name']]
        );

        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $data['service_id'],
            'doctor_id' => 1,
            'appointment_at' => $data['appointment_at'],
            'status' => 'pending',
            'note' => $data['note'] ?? null,
        ]);

        return response()->json($appt, 201);
    }
}
