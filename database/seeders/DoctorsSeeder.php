<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        // Single doctor/admin for the clinic using env config
        Doctor::firstOrCreate(
            ['name' => env('DOCTOR_NAME', 'BS. Nguyễn Văn Việt')],
            [
                'name' => env('DOCTOR_NAME', 'BS. Nguyễn Văn Việt'),
                'specialty' => 'Bác sĩ nha khoa tổng quát',
                'bio' => 'Bác sĩ nha khoa với 10 năm kinh nghiệm, chuyên về điều trị và phục hồi răng.',
                'user_id' => 1, // Link to admin user
            ]
        );
    }
}
