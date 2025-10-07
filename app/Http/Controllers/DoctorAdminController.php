<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Doctor;
use App\Support\AuditLogger;

class DoctorAdminController extends Controller
{
    public function images()
    {
        Gate::authorize('manage-images');
        // Redirect to unified images page so administrators can manage all in one place
        $prefix = trim(env('ADMIN_PREFIX','admin'), '/');
        return redirect("/{$prefix}/images");
    }

    public function uploadPhoto(Request $request, $id)
    {
        Gate::authorize('manage-images');
        $doctor = Doctor::findOrFail($id);
        $request->validate([
            'photo' => ['required','image','max:5120'],
        ]);
        $file = $request->file('photo');
        $doctor->photo = file_get_contents($file->getRealPath());
        $doctor->photo_mime = $file->getMimeType();
        $doctor->save();
        AuditLogger::log('doctor.photo.uploaded', $doctor, [
            'doctor_id' => $doctor->id,
            'user_id' => $request->user()?->id,
        ]);
        return back()->with('status', 'Đã cập nhật ảnh cho bác sĩ: '.$doctor->name);
    }
}
