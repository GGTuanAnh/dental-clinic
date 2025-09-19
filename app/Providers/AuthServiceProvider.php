<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Appointment;
use App\Models\Patient;
use App\Policies\AppointmentPolicy;
use App\Policies\PatientPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
        Patient::class => PatientPolicy::class,
        // Image management uses custom gate via ImagePolicy manage method conceptually
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gates based on simple roles
        Gate::define('manage-images', fn($user) => $user->isAdmin() || $user->isDoctor());
        Gate::define('view-reports', fn($user) => $user->isAdmin());
        Gate::define('manage-appointments', fn($user) => $user->isAdmin() || $user->isStaff());
    }
}