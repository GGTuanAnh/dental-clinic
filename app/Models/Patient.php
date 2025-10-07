<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'dob', 'gender', 'phone', 'address'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function notes()
    {
        return $this->hasMany(PatientNote::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
