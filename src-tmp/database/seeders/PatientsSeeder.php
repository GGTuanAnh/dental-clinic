<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Carbon\Carbon;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 100 bệnh nhân mẫu với dữ liệu đa dạng
        $firstNames = [
            'male' => ['An', 'Minh', 'Hoàng', 'Đức', 'Anh', 'Thành', 'Hải', 'Tuấn', 'Hùng', 'Quang', 'Phong', 'Long', 'Nam', 'Khoa', 'Duy', 'Tùng', 'Cường', 'Kiên', 'Sơn', 'Bình'],
            'female' => ['Thảo', 'Thu', 'Mai', 'Lan', 'Hương', 'Linh', 'Nga', 'Hà', 'Trang', 'Nhung', 'Phương', 'Huyền', 'Anh', 'Dung', 'Hiền', 'My', 'Vy', 'Giang', 'Nhi', 'Chi']
        ];
        
        $lastNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ', 'Võ', 'Đặng', 'Bùi', 'Đỗ', 'Hồ', 'Ngô', 'Dương', 'Lý', 'Trương', 'Đinh', 'Mai', 'Tạ'];
        
        $middleNames = ['Văn', 'Thị', 'Hữu', 'Đình', 'Ngọc', 'Công', 'Quốc', 'Thanh', 'Xuân', 'Kim', 'Phước', 'Minh', 'Gia', 'Bảo', 'An'];
        
        $districts = [
            'TP. Ninh Bình',
            'TX. Tam Điệp',
            'Huyện Hoa Lư',
            'Huyện Gia Viễn',
            'Huyện Nho Quan',
            'Huyện Kim Sơn',
            'Huyện Yên Mô',
            'Huyện Yên Khánh'
        ];
        
        $streets = ['Trần Hưng Đạo', 'Lê Hồng Phong', 'Trần Phú', 'Hoàng Hoa Thám', 'Lê Lợi', 'Phan Đình Phùng', 'Đinh Tiên Hoàng', 'Nguyễn Du', 'Võ Nguyên Giáp', 'Hai Bà Trưng', 'Quang Trung', 'Tràng An', 'Bái Đính', 'Tam Cốc'];
        
        $colors = ['0D8ABC', 'E91E63', '2196F3', '9C27B0', '00BCD4', 'FF5722', '607D8B', 'F44336', '4CAF50', 'FF9800', '795548', '3F51B5', '009688', '673AB7', '8BC34A', 'FFC107', 'FF5252', 'CDDC39'];

        $patients = [];
        
        // Tạo 100 bệnh nhân
        for ($i = 0; $i < 100; $i++) {
            $gender = $i % 2 === 0 ? 'male' : 'female';
            $lastName = $lastNames[array_rand($lastNames)];
            $middleName = $middleNames[array_rand($middleNames)];
            $firstName = $firstNames[$gender][array_rand($firstNames[$gender])];
            $name = "$lastName $middleName $firstName";
            
            $phone = '09' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            $dob = Carbon::now()->subYears(rand(18, 70))->subDays(rand(1, 365))->format('Y-m-d');
            
            $houseNumber = rand(1, 500);
            $street = $streets[array_rand($streets)];
            $district = $districts[array_rand($districts)];
            $address = "$houseNumber Đường $street, $district, Ninh Bình";
            
            $color = $colors[array_rand($colors)];
            $avatarName = urlencode($name);
            $avatar = "https://ui-avatars.com/api/?name=$avatarName&background=$color&color=fff&size=200";
            
            $patients[] = [
                'name' => $name,
                'phone' => $phone,
                'dob' => $dob,
                'gender' => $gender,
                'address' => $address,
                'avatar' => $avatar,
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert tất cả patients
        foreach ($patients as $patient) {
            Patient::create($patient);
        }

        $this->command->info('✅ Đã tạo 100 bệnh nhân mẫu!');
    }
}

