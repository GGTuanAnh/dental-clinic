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
        User::firstOrCreate(
            ['email' => env('DOCTOR_EMAIL', 'bsviet@clinic.com')],
            [
                'name' => env('DOCTOR_NAME', 'BS. Nguyễn Văn Việt'),
                'password' => Hash::make(env('DOCTOR_PASSWORD', 'password')),
                'role' => 'admin', // Admin role includes doctor privileges
            ]
        );
    }
}