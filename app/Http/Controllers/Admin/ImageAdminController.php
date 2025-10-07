<?php
namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Banner;
use Illuminate\Support\Facades\Gate;

class ImageAdminController extends BaseAdminController
{
    public function index()
    {
        Gate::authorize('manage-images');
        $doctors = Doctor::orderBy('id','desc')->get();
        $services = Service::orderBy('id','desc')->get();
        $banners = Banner::orderBy('id','desc')->get();
        return $this->renderView('admin.images_all', compact('doctors','services','banners'), 'Quản lý hình ảnh');
    }
}
