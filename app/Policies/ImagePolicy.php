<?php
namespace App\Policies;

use App\Models\User;

class ImagePolicy
{
    public function manage(User $user): bool { return $user->isAdmin() || $user->isDoctor(); }
}