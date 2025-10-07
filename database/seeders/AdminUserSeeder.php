<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Single admin/doctor user for the clinic using env config
        $user = User::firstOrCreate(
            ['email' => env('DOCTOR_EMAIL', 'bsviet@clinic.com')],
            [
                'name' => env('DOCTOR_NAME', 'BS. Nguyễn Văn Việt'),
                'password' => Hash::make(env('DOCTOR_PASSWORD', 'password')),
                'role' => 'admin', // Admin role includes doctor privileges
                'force_password_reset' => true,
            ]
        );

        if ($user->wasRecentlyCreated) {
            $user->password_changed_at = null;
            $user->save();
        }
    }
}
