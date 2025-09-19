<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'service_id', 'appointment_at', 'status', 'note',
        'doctor_id', 'total_amount', 'paid_at', 'follow_up_at'
    ];

    protected $casts = [
        'appointment_at' => 'datetime',
        'paid_at' => 'datetime',
        'follow_up_at' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}
