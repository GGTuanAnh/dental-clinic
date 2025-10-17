<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Patient;

class PatientPolicy
{
    public function viewAny(User $user): bool { return $user->isAdmin() || $user->isStaff(); }
    public function view(User $user, Patient $patient): bool { return $user->isAdmin() || $user->isStaff(); }
    public function addNote(User $user, Patient $patient): bool { return $user->isAdmin() || $user->isStaff(); }
}