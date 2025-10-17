<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerAdminController extends Controller
{
    public function uploadImage(Request $request, int $id)
    {
        $banner = Banner::findOrFail($id);
        $request->validate([
            'image' => ['required','image','max:5120'], // 5MB
        ]);
        $file = $request->file('image');
        $banner->image = file_get_contents($file->getRealPath());
        $banner->image_mime = $file->getMimeType();
        $banner->save();
        return back()->with('status', 'Đã cập nhật ảnh banner.');
    }
}
