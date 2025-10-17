<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['name','specialty','bio','photo','photo_mime','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
