<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersSeeder extends Seeder
{
    public function run(): void
    {
        Banner::firstOrCreate(
            ['title' => 'Nha Khoa An Việt'],
            [
                'subtitle' => 'Nụ cười tự tin bắt đầu từ đây',
                'cta_text' => 'Đặt lịch ngay',
                'cta_link' => '/booking',
                'image' => null,
                'image_mime' => null,
            ]
        );
    }
}
