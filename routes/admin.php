<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceAdminController;
use App\Http\Controllers\DoctorAdminController;
use App\Http\Controllers\Admin\AppointmentAdminController;
use App\Http\Controllers\Admin\PatientAdminController;
use App\Http\Controllers\Admin\ReportAdminController;
use App\Http\Controllers\Admin\ImageAdminController;
use App\Http\Controllers\BannerAdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordController;

$adminPrefix = trim(env('ADMIN_PREFIX', 'admin'), '/');

// Session-based auth routes (public)
Route::prefix($adminPrefix)->name('admin.')->group(function(){
    Route::get('/login', [AdminAuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class,'login'])->middleware('throttle:5,1')->name('login.post');
});

// Protected admin routes
Route::prefix($adminPrefix)
    ->middleware('auth')
    ->as('admin.')
    ->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('home');
    // Password change
    Route::get('/password', [PasswordController::class,'edit'])->name('password.edit');
    Route::post('/password', [PasswordController::class,'update'])->name('password.update');

        // Upload images (services/doctors)
        Route::get('/services/images', [ServiceAdminController::class,'images'])->name('services.images');
        Route::post('/services/{id}/image', [ServiceAdminController::class,'uploadImage'])->name('services.upload');
        Route::get('/doctors/images', [DoctorAdminController::class,'images'])->name('doctors.images');
        Route::post('/doctors/{id}/photo', [DoctorAdminController::class,'uploadPhoto'])->name('doctors.upload');

        // Appointments
        Route::get('/appointments', [AppointmentAdminController::class, 'index'])->name('appointments.index');
        Route::post('/appointments/{id}', [AppointmentAdminController::class, 'update'])->name('appointments.update');

        // Patients
        Route::get('/patients', [PatientAdminController::class, 'index'])->name('patients.index');
        Route::get('/patients/{id}', [PatientAdminController::class, 'show'])->name('patients.show');
        // addNote route removed as PatientNote model doesn't exist

        // Reports
    Route::get('/reports', [ReportAdminController::class, 'index'])->middleware('can:view-reports')->name('reports.index');

        // All images management
    Route::get('/images', [ImageAdminController::class,'index'])->middleware('can:manage-images')->name('images.index');
        Route::post('/banners/{id}/image', [BannerAdminController::class,'uploadImage'])->name('banners.upload');
        Route::post('/logout', [AdminAuthController::class,'logout'])->name('logout');
    });
