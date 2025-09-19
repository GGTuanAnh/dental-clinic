<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        // Doctors need read-only access so they can review their own schedule.
        // AppointmentAdminController::index() scopes doctor accounts to only
        // their appointments, so it's safe to allow them here while still
        // keeping mutation actions restricted to admins/staff via update().
        return $user->isAdmin() || $user->isStaff() || $user->isDoctor();
    }
    public function update(User $user, Appointment $appointment): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }
}