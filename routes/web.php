<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\HealthController;

// Public site routes
Route::get('/', [LandingController::class,'home']);
Route::get('/services', [LandingController::class,'services']);
Route::get('/about', [LandingController::class,'about']);
Route::get('/contact', [LandingController::class,'contact']);
Route::view('/gallery', 'landing.gallery');
Route::view('/pricing', 'landing.pricing');
Route::view('/faq', 'landing.faq');
Route::view('/testimonials', 'landing.testimonials');

// Local health check (only in local env)
if (env('APP_ENV') === 'local') {
	Route::get('/_health', [HealthController::class, 'index']);
}

// Booking
Route::get('/booking', [BookingController::class, 'showForm'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'storePublic'])
	->middleware('throttle:10,1')
	->name('booking.store');

// Admin routes extracted
require __DIR__.'/admin.php';
Route::get('/media/service/{id}', [MediaController::class,'service']);
Route::get('/media/doctor/{id}', [MediaController::class,'doctor']);
Route::get('/media/banner/{id}', [MediaController::class,'banner']);

// (deprecated) Static /admin group removed in favor of configurable prefix above
