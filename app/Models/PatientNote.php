<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientNote extends Model
{
    protected $fillable = ['patient_id','note'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
