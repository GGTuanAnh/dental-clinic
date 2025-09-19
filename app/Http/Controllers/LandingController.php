<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Doctor;
use App\Models\Banner;

class LandingController extends Controller
{
    public function home()
    {
        // Prefer the newest banner that has an image; fallback to latest record
        $banner = Banner::orderByDesc('id')->whereNotNull('image')->first() ?? Banner::latest()->first();
        $hotServices = Service::orderBy('id','asc')->take(3)->get();
        $team = Doctor::orderBy('id','asc')->take(3)->get();
        return view('landing.home', compact('banner','hotServices','team'));
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
}
