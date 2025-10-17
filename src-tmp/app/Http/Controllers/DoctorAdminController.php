<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorAdminController extends Controller
{
    public function images()
    {
        // Redirect to unified images page so administrators can manage all in one place
        $prefix = trim(env('ADMIN_PREFIX','admin'), '/');
        return redirect("/{$prefix}/images");
    }

    public function uploadPhoto(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $request->validate([
            'photo' => ['required','image','max:5120'],
        ]);
        $file = $request->file('photo');
        $doctor->photo = file_get_contents($file->getRealPath());
        $doctor->photo_mime = $file->getMimeType();
        $doctor->save();
        return back()->with('status', 'Đã cập nhật ảnh cho bác sĩ: '.$doctor->name);
    }
}
