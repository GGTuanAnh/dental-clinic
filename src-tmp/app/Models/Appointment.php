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
        'total_amount' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    // Eager loading relationships to prevent N+1 queries
    protected $with = [];

    // Add indexes for common queries
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_at', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

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

    // Removed prescription relationship as table doesn't exist
}
