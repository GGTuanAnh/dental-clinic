<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceAdminController extends Controller
{
    // Simple page to list services and upload image per service
    public function images()
    {
        $services = Service::orderBy('id','desc')->paginate(12);
        return view('admin.services_images', compact('services'));
    }

    public function uploadImage(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'image' => ['required','image','max:5120'], // 5MB
        ]);
        $file = $request->file('image');
        $service->image = file_get_contents($file->getRealPath());
        $service->image_mime = $file->getMimeType();
        $service->save();
        return back()->with('status', 'Đã cập nhật ảnh cho dịch vụ: '.$service->name);
    }
}
