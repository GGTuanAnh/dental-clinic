<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryImage;

class GalleryImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            // Phòng khám & Cơ sở vật chất
            [
                'title' => 'Phòng khám hiện đại',
                'description' => 'Khu vực tiếp đón rộng rãi, thoáng mát',
                'image_url' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=1200&auto=format&fit=crop',
                'category' => 'clinic',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Phòng điều trị tiệt trùng',
                'description' => 'Phòng điều trị đạt chuẩn y tế',
                'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=1200&auto=format&fit=crop',
                'category' => 'clinic',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Ghế nha khoa cao cấp',
                'description' => 'Ghế điều trị êm ái, thoải mái',
                'image_url' => 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=1200&auto=format&fit=crop',
                'category' => 'equipment',
                'order' => 3,
                'is_featured' => false,
            ],
            [
                'title' => 'Khu vực chờ tiện nghi',
                'description' => 'Không gian chờ đợi thoải mái',
                'image_url' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1200&auto=format&fit=crop',
                'category' => 'clinic',
                'order' => 4,
                'is_featured' => false,
            ],

            // Điều trị & Dịch vụ
            [
                'title' => 'Niềng răng Invisalign',
                'description' => 'Công nghệ niềng răng trong suốt',
                'image_url' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f53?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 5,
                'is_featured' => true,
            ],
            [
                'title' => 'Tẩy trắng răng',
                'description' => 'Răng trắng sáng chỉ sau 60 phút',
                'image_url' => 'https://images.unsplash.com/photo-1609864228387-ee5cc7d29e1e?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 6,
                'is_featured' => true,
            ],
            [
                'title' => 'Cấy ghép Implant',
                'description' => 'Phục hồi răng mất vĩnh viễn',
                'image_url' => 'https://images.unsplash.com/photo-1588771930291-88d8d421a27e?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 7,
                'is_featured' => false,
            ],
            [
                'title' => 'Bọc răng sứ thẩm mỹ',
                'description' => 'Răng đều đẹp, tự nhiên',
                'image_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 8,
                'is_featured' => false,
            ],

            // Đội ngũ bác sĩ
            [
                'title' => 'Đội ngũ bác sĩ chuyên nghiệp',
                'description' => 'Bác sĩ giàu kinh nghiệm, tận tâm',
                'image_url' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=1200&auto=format&fit=crop',
                'category' => 'team',
                'order' => 9,
                'is_featured' => true,
            ],
            [
                'title' => 'Chăm sóc tận tình',
                'description' => 'Luôn lắng nghe và thấu hiểu',
                'image_url' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1200&auto=format&fit=crop',
                'category' => 'team',
                'order' => 10,
                'is_featured' => false,
            ],

            // Thiết bị & Công nghệ
            [
                'title' => 'Máy X-quang kỹ thuật số',
                'description' => 'Chụp phim chính xác, ít bức xạ',
                'image_url' => 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=1200&auto=format&fit=crop',
                'category' => 'equipment',
                'order' => 11,
                'is_featured' => false,
            ],
            [
                'title' => 'Công nghệ CAD/CAM',
                'description' => 'Thiết kế và chế tạo răng sứ ngay tại phòng khám',
                'image_url' => 'https://images.unsplash.com/photo-1583912267550-bc4f0c61d3c3?w=1200&auto=format&fit=crop',
                'category' => 'equipment',
                'order' => 12,
                'is_featured' => false,
            ],

            // Before & After
            [
                'title' => 'Kết quả niềng răng',
                'description' => 'Trước và sau 18 tháng niềng răng',
                'image_url' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f53?w=1200&auto=format&fit=crop',
                'category' => 'before_after',
                'order' => 13,
                'is_featured' => true,
            ],
            [
                'title' => 'Kết quả bọc răng sứ',
                'description' => 'Răng đều đẹp sau 1 tuần',
                'image_url' => 'https://images.unsplash.com/photo-1597348930068-5f2b07e25c23?w=1200&auto=format&fit=crop',
                'category' => 'before_after',
                'order' => 14,
                'is_featured' => true,
            ],
            [
                'title' => 'Kết quả tẩy trắng răng',
                'description' => 'Răng trắng sáng tự nhiên',
                'image_url' => 'https://images.unsplash.com/photo-1527613426441-4da17471b66d?w=1200&auto=format&fit=crop',
                'category' => 'before_after',
                'order' => 15,
                'is_featured' => false,
            ],

            // Thêm hình ảnh nụ cười khỏe đẹp
            [
                'title' => 'Nụ cười tự tin',
                'description' => 'Khách hàng hài lòng sau điều trị',
                'image_url' => 'https://images.unsplash.com/photo-1526047932273-341f2a7631f9?w=1200&auto=format&fit=crop',
                'category' => 'general',
                'order' => 16,
                'is_featured' => false,
            ],
            [
                'title' => 'Nụ cười rạng rỡ',
                'description' => 'Răng trắng đều đẹp',
                'image_url' => 'https://images.unsplash.com/photo-1629909615184-74f495363b67?w=1200&auto=format&fit=crop',
                'category' => 'general',
                'order' => 17,
                'is_featured' => false,
            ],
            [
                'title' => 'Chăm sóc răng miệng cho trẻ em',
                'description' => 'Dịch vụ nha khoa nhi đồng chuyên nghiệp',
                'image_url' => 'https://images.unsplash.com/photo-1611252200152-e6f1f9c5d0bc?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 18,
                'is_featured' => false,
            ],
            [
                'title' => 'Tư vấn tận tình',
                'description' => 'Bác sĩ tư vấn kỹ lưỡng trước điều trị',
                'image_url' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=1200&auto=format&fit=crop',
                'category' => 'team',
                'order' => 19,
                'is_featured' => false,
            ],
            [
                'title' => 'Vệ sinh răng miệng định kỳ',
                'description' => 'Lấy cao răng chuyên sâu',
                'image_url' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=1200&auto=format&fit=crop',
                'category' => 'treatment',
                'order' => 20,
                'is_featured' => false,
            ],
        ];

        foreach ($images as $image) {
            GalleryImage::create($image);
        }

        $this->command->info('✅ Đã tạo ' . count($images) . ' hình ảnh gallery!');
    }
}
