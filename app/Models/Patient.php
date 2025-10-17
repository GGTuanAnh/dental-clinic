<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'dob', 'gender', 'phone', 'address'];

    protected $casts = [
        'dob' => 'date',
    ];

    // Add scopes for common queries
    public function scopeByPhone($query, $phone)
    {
        return $query->where('phone', $phone);
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Get latest appointment
    public function latestAppointment()
    {
        return $this->hasOne(Appointment::class)->latest('appointment_at');
    }

    // Get completed appointments count
    public function getCompletedAppointmentsCountAttribute()
    {
        return $this->appointments()->where('status', 'completed')->count();
    }

    // Get full address formatted
    public function getFullAddressAttribute()
    {
        return $this->address ?: 'Chưa cập nhật địa chỉ';
    }
}
