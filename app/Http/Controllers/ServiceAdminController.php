<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Service;
use App\Support\AuditLogger;

class ServiceAdminController extends Controller
{
    // Simple page to list services and upload image per service
    public function images()
    {
        Gate::authorize('manage-images');
        $services = Service::orderBy('id','desc')->paginate(12);
        return view('admin.services_images', compact('services'));
    }

    public function uploadImage(Request $request, $id)
    {
        Gate::authorize('manage-images');
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'image' => ['required','image','max:5120'], // 5MB
        ]);
        $file = $request->file('image');
        $service->image = file_get_contents($file->getRealPath());
        $service->image_mime = $file->getMimeType();
        $service->save();
        AuditLogger::log('service.image.uploaded', $service, [
            'service_id' => $service->id,
            'user_id' => $request->user()?->id,
        ]);
        return back()->with('status', 'Đã cập nhật ảnh cho dịch vụ: '.$service->name);
    }
}
