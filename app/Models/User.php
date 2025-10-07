<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'force_password_reset',
        'password_changed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'force_password_reset' => 'boolean',
            'password_changed_at' => 'datetime',
        ];
    }

    // ---- Role helpers --------------------------------------------------
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isDoctor(): bool { 
        // Admin role includes doctor privileges since we have one person doing both
        return $this->role === 'doctor' || $this->role === 'admin'; 
    }
    public function isStaff(): bool { return $this->role === 'staff'; }

    // Relation: one user (role doctor) may map to a doctor profile
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}
