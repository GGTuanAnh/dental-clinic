<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate; 
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Banner;

class ImageAdminController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-images');
        $doctors = Doctor::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        $banners = Banner::orderBy('id','desc')->get();
        return view('admin.images_all', compact('doctors','services','banners'));
    }
}
