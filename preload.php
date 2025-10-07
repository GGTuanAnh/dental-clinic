<?php
// Preload script for Laravel Dental Clinic
// This file preloads commonly used classes to improve performance

if (function_exists('opcache_compile_file')) {
    // Core Laravel files
    $laravelFiles = [
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Foundation/Application.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Container/Container.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Http/Request.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Http/Response.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Routing/Router.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php',
        __DIR__ . '/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php',
    ];
    
    // Application files
    $appFiles = [
        __DIR__ . '/app/Models/User.php',
        __DIR__ . '/app/Models/Patient.php',
        __DIR__ . '/app/Models/Appointment.php',
        __DIR__ . '/app/Models/Service.php',
        __DIR__ . '/app/Models/Doctor.php',
        __DIR__ . '/app/Http/Controllers/Controller.php',
        __DIR__ . '/app/Http/Controllers/Admin/DashboardController.php',
        __DIR__ . '/app/Http/Controllers/Admin/AppointmentAdminController.php',
        __DIR__ . '/app/Providers/AppServiceProvider.php',
    ];
    
    $allFiles = array_merge($laravelFiles, $appFiles);
    
    foreach ($allFiles as $file) {
        if (file_exists($file)) {
            opcache_compile_file($file);
        }
    }
}