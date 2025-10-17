<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Khám & chẩn đoán
            ['name' => 'Khám tổng quát + tư vấn', 'price' => 50000, 'description' => 'Khám và tư vấn tình trạng răng miệng'],
            ['name' => 'Chụp phim quanh chóp (Periapical)', 'price' => 50000, 'description' => 'Chụp X-quang chi tiết 1 răng'],
            ['name' => 'Chụp phim Panoramic (Pano)', 'price' => 150000, 'description' => 'Chụp toàn cảnh 2 hàm răng'],
            ['name' => 'Chụp phim Cephalometric', 'price' => 150000, 'description' => 'Chụp phim sọ nghiêng cho chỉnh nha'],
            ['name' => 'Chụp CT / CBCT', 'price' => 550000, 'description' => 'Chụp CT 3D cho implant, phẫu thuật'],

            // Vệ sinh / nha chu
            ['name' => 'Lấy cao răng + đánh bóng (2 hàm)', 'price' => 180000, 'description' => 'Vệ sinh răng miệng định kỳ'],
            ['name' => 'Điều trị viêm lợi / nạo túi nha chu', 'price' => 350000, 'description' => 'Điều trị bệnh lý nha chu mỗi răng'],

            // Trám răng / phục hồi
            ['name' => 'Trám răng composite thường', 'price' => 200000, 'description' => 'Trám răng sâu bằng composite'],
            ['name' => 'Trám răng thẩm mỹ cao cấp', 'price' => 450000, 'description' => 'Trám thẩm mỹ với composite cao cấp'],

            // Nội nha (chữa tủy)
            ['name' => 'Chữa tủy răng cửa / răng nhỏ', 'price' => 1000000, 'description' => 'Điều trị tủy răng 1-2 ống tủy'],
            ['name' => 'Chữa tủy răng nhiều ống tủy', 'price' => 1600000, 'description' => 'Điều trị tủy răng hàm phức tạp'],
            ['name' => 'Chữa tủy lại', 'price' => 1800000, 'description' => 'Chữa tủy lại cho răng đã chữa trước'],

            // Nhổ răng / tiểu phẫu
            ['name' => 'Nhổ răng đơn giản', 'price' => 300000, 'description' => 'Nhổ răng lung lay, dễ'],
            ['name' => 'Nhổ răng khôn mọc thẳng', 'price' => 850000, 'description' => 'Nhổ răng số 8 mọc thẳng'],
            ['name' => 'Nhổ răng khôn mọc lệch / ngầm', 'price' => 2000000, 'description' => 'Tiểu phẫu nhổ răng khôn khó'],
            ['name' => 'Cắt lợi / tạo hình nướu', 'price' => 500000, 'description' => 'Phẫu thuật nha chu thẩm mỹ'],

            // Phục hình cố định / răng sứ
            ['name' => 'Răng sứ kim loại thường', 'price' => 1750000, 'description' => 'Bọc răng sứ kim loại cơ bản'],
            ['name' => 'Răng sứ Titan', 'price' => 2750000, 'description' => 'Răng sứ khung Titan cao cấp'],
            ['name' => 'Răng sứ Zirconia toàn sứ', 'price' => 5000000, 'description' => 'Răng toàn sứ cao cấp, thẩm mỹ tối đa'],
            ['name' => 'Veneer / mặt dán sứ', 'price' => 8500000, 'description' => 'Dán sứ thẩm mỹ không mài răng'],

            // Phục hình tháo lắp
            ['name' => 'Hàm nhựa cứng / bán phần', 'price' => 3250000, 'description' => 'Răng giả tháo lắp nhựa'],
            ['name' => 'Hàm khung kim loại / Titan', 'price' => 5000000, 'description' => 'Hàm tháo lắp khung kim loại cao cấp'],

            // Cấy ghép Implant
            ['name' => 'Implant trung bình + abutment', 'price' => 18500000, 'description' => 'Trụ implant + chân răng'],
            ['name' => 'Implant cao cấp nhập khẩu', 'price' => 35000000, 'description' => 'Implant thương hiệu Châu Âu, Mỹ'],
            ['name' => 'Mão sứ trên implant', 'price' => 5000000, 'description' => 'Răng sứ gắn trên trụ implant'],

            // Chỉnh nha (niềng răng)
            ['name' => 'Niềng răng mắc cài kim loại', 'price' => 27500000, 'description' => 'Chỉnh nha truyền thống 2 hàm'],
            ['name' => 'Niềng răng mắc cài sứ tự buộc', 'price' => 40000000, 'description' => 'Niềng răng thẩm mỹ, tiện lợi'],
            ['name' => 'Niềng răng khay trong suốt (Aligner)', 'price' => 70000000, 'description' => 'Chỉnh nha không mắc cài, tháo lắp được'],
            ['name' => 'Tháo mắc cài + hàm duy trì', 'price' => 2000000, 'description' => 'Kết thúc chỉnh nha, giữ kết quả'],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(['name' => $s['name']], $s);
        }

        $this->command->info('✅ Đã tạo ' . count($services) . ' dịch vụ nha khoa!');
    }
}
