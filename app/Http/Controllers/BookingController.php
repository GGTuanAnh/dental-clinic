<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'appointment_at' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $patient = Patient::firstOrCreate(
            ['phone' => $validated['phone']],
            ['name' => $validated['name']]
        );

        $appt = Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => $validated['service_id'],
            'appointment_at' => $validated['appointment_at'],
            'note' => $validated['note'] ?? null,
        ]);

        event(new BookingCreated($appt));

        return back()->with('success', 'Đặt lịch thành công. Chúng tôi sẽ liên hệ xác nhận.');
    }
}
