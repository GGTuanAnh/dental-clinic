<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Banner;
use App\Support\AuditLogger;

class BannerAdminController extends Controller
{
    public function uploadImage(Request $request, int $id)
    {
        Gate::authorize('manage-images');
        $banner = Banner::findOrFail($id);
        $request->validate([
            'image' => ['required','image','max:5120'], // 5MB
        ]);
        $file = $request->file('image');
        $banner->image = file_get_contents($file->getRealPath());
        $banner->image_mime = $file->getMimeType();
        $banner->save();
        AuditLogger::log('banner.image.uploaded', $banner, [
            'banner_id' => $banner->id,
            'user_id' => $request->user()?->id,
        ]);
        return back()->with('status', 'Đã cập nhật ảnh banner.');
    }
}
