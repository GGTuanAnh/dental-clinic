<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Trám răng', 'price' => 200000, 'description'=>'Khôi phục cấu trúc răng hư tổn.'],
            ['name' => 'Nhổ răng', 'price' => 300000, 'description'=>'Xử lý răng sâu, viêm nhiễm khó cứu.'],
            ['name' => 'Cạo vôi', 'price' => 150000, 'description'=>'Làm sạch mảng bám, bảo vệ nướu.'],
        ];
        foreach ($services as $s) {
            Service::firstOrCreate(['name' => $s['name']], $s);
        }
    }
}
