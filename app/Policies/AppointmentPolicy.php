<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;

class AppointmentPolicy
{
    public function viewAny(User $user): bool { return $user->isAdmin() || $user->isStaff(); }
    public function update(User $user, Appointment $appointment): bool { return $user->isAdmin() || $user->isStaff(); }
}