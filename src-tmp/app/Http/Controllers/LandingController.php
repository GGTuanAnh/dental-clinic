<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Doctor;
use App\Models\Banner;
use App\Models\GalleryImage;

class LandingController extends Controller
{
    public function home()
    {
        // Prefer the newest banner that has an image; fallback to latest record
        $banner = Banner::orderByDesc('id')->whereNotNull('image')->first() ?? Banner::latest()->first();
        $hotServices = Service::orderBy('id','asc')->take(3)->get();
        $team = Doctor::orderBy('id','asc')->take(3)->get();
        $galleryImages = GalleryImage::where('is_featured', true)->orderBy('order')->take(6)->get();
        
        return view('landing.home', compact('banner','hotServices','team', 'galleryImages'));
    }

    public function services()
    {
        $services = Service::orderBy('name')->paginate(9);
        return view('landing.services', compact('services'));
    }

    public function about()
    {
        $team = Doctor::orderBy('id','asc')->take(6)->get();
        return view('landing.about', compact('team'));
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function gallery()
    {
        $images = GalleryImage::orderBy('order')->orderBy('id')->get();
        $featured = $images->where('is_featured', true);
        $byCategory = $images->groupBy('category');
        
        return view('landing.gallery', compact('images', 'featured', 'byCategory'));
    }
}
