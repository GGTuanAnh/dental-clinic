<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowConfig extends Command
{
    protected $signature = 'config:show';
    protected $description = 'Display current application configuration';

    public function handle()
    {
        $this->info('🔧 DENTAL CLINIC CONFIGURATION');
        $this->info('===============================');
        $this->line('');

        // Application Config
        $this->info('📱 APPLICATION:');
        $this->line('  Name: ' . env('APP_NAME'));
        $this->line('  Environment: ' . env('APP_ENV'));
        $this->line('  Debug: ' . (env('APP_DEBUG') ? 'Enabled' : 'Disabled'));
        $this->line('  URL: ' . env('APP_URL'));
        $this->line('  Timezone: ' . env('APP_TIMEZONE'));
        $this->line('');

        // Database Config
        $this->info('🗄️ DATABASE (Aiven Cloud MySQL):');
        $this->line('  Connection: ' . env('DB_CONNECTION'));
        $this->line('  Host: ' . env('DB_HOST'));
        $this->line('  Port: ' . env('DB_PORT'));
        $this->line('  Database: ' . env('DB_DATABASE'));
        $this->line('  Username: ' . env('DB_USERNAME'));
        $this->line('  SSL Mode: ' . env('DB_SSLMODE', 'Not set'));
        $this->line('');

        // Doctor/Admin Config
        $this->info('👨‍⚕️ DOCTOR/ADMIN:');
        $this->line('  Name: ' . env('DOCTOR_NAME'));
        $this->line('  Email: ' . env('DOCTOR_EMAIL'));
        $this->line('  Password: ' . (env('DOCTOR_PASSWORD') ? '***' : 'Not set'));
        $this->line('');

        // Aiven Config
        $this->info('☁️ AIVEN CLOUD:');
        $this->line('  Project: ' . env('AIVEN_PROJECT_NAME'));
        $this->line('  API Token: ' . (env('AIVEN_API_TOKEN') ? 'Set (***' . substr(env('AIVEN_API_TOKEN'), -10) . ')' : 'Not set'));
        $this->line('');

        // System Config
        $this->info('⚙️ SYSTEM:');
        $this->line('  Cache Driver: ' . env('CACHE_DRIVER'));
        $this->line('  Session Driver: ' . env('SESSION_DRIVER'));
        $this->line('  Queue Connection: ' . env('QUEUE_CONNECTION'));
        $this->line('  Broadcast Driver: ' . env('BROADCAST_DRIVER'));
        $this->line('');

        // Quick Actions
        $this->info('🚀 QUICK ACTIONS:');
        $this->line('  Test Aiven API: php artisan aiven:status');
        $this->line('  Show Login Info: php artisan clinic:show-login');
        $this->line('  Admin URL: ' . env('APP_URL') . '/admin');
        $this->line('');

        $this->comment('✅ Configuration loaded successfully!');
    }
}