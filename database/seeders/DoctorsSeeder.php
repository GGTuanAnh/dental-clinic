<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorsSeeder extends Seeder
{
    public function run(): void
    {
        $docs = [
            ['name'=>'BS. Nguyễn An','specialty'=>'Chỉnh nha','bio'=>'10 năm kinh nghiệm chỉnh nha.'],
            ['name'=>'BS. Trần Việt','specialty'=>'Phục hình','bio'=>'Chuyên phục hình răng sứ thẩm mỹ.'],
            ['name'=>'BS. Lê Minh','specialty'=>'Nội nha','bio'=>'Điều trị tủy nhẹ nhàng, hiệu quả.'],
        ];
        foreach ($docs as $d) {
            Doctor::firstOrCreate(['name'=>$d['name']], $d);
        }
    }
}
