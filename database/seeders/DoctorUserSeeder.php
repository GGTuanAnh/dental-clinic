<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorUserSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = Doctor::first();
        if(!$doctor){
            $doctor = Doctor::create([
                'name' => 'Bác sĩ Demo',
                'specialty' => 'Tổng quát',
                'bio' => 'Demo profile',
            ]);
        }

        if(!$doctor->user_id){
            $user = User::firstOrCreate(
                ['email' => 'doctor@example.com'],
                [
                    'name' => 'Doctor Account',
                    'password' => Hash::make('DoctorPass123!'),
                    'role' => 'doctor'
                ]
            );
            $doctor->user_id = $user->id;
            $doctor->save();
        }
    }
}