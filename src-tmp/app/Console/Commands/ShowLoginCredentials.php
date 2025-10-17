<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowLoginCredentials extends Command
{
    protected $signature = 'clinic:show-login';
    protected $description = 'Show default login credentials for the clinic';

    public function handle()
    {
        $this->info('🏥 Dental Clinic Login Credentials');
        $this->info('================================');
        $this->line('');
        $this->line('Doctor/Admin: ' . env('DOCTOR_NAME', 'BS. Nguyễn Văn Việt'));
        $this->line('Email: ' . env('DOCTOR_EMAIL', 'bsviet@clinic.com'));
        $this->line('Password: ' . env('DOCTOR_PASSWORD', 'password'));
        $this->line('');
        $this->line('Admin URL: ' . config('app.url') . '/admin');
        $this->line('');
        $this->comment('Note: Change DOCTOR_PASSWORD in .env for production use');
    }
}