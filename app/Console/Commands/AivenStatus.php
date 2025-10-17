<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AivenStatus extends Command
{
    protected $signature = 'aiven:status';
    protected $description = 'Check Aiven service status and project information';

    public function handle()
    {
        $token = env('AIVEN_API_TOKEN');
        $project = env('AIVEN_PROJECT_NAME');

        if (!$token) {
            $this->error('❌ AIVEN_API_TOKEN not found in .env');
            return 1;
        }

        if (!$project) {
            $this->error('❌ AIVEN_PROJECT_NAME not found in .env');
            return 1;
        }

        $this->info('🌐 Checking Aiven Connection...');
        $this->line('');

        try {
            // Test API connection with SSL verification disabled for local development
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])
            ->withOptions([
                'verify' => false, // Disable SSL verification for local development
            ])
            ->get("https://api.aiven.io/v1/project/{$project}");

            if ($response->successful()) {
                $projectInfo = $response->json();
                
                $this->info('✅ Aiven API Connection: SUCCESS');
                $this->line('');
                
                $this->line('📋 Project Information:');
                $this->line('  Name: ' . $projectInfo['project']['project_name']);
                $this->line('  Description: ' . ($projectInfo['project']['description'] ?? 'N/A'));
                $this->line('  Country: ' . $projectInfo['project']['country_code']);
                $this->line('  Cloud: ' . $projectInfo['project']['default_cloud']);
                
                // Get services
                $servicesResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->withOptions([
                    'verify' => false,
                ])
                ->get("https://api.aiven.io/v1/project/{$project}/service");

                if ($servicesResponse->successful()) {
                    $services = $servicesResponse->json()['services'];
                    
                    $this->line('');
                    $this->line('🗄️ Services (' . count($services) . ' total):');
                    
                    foreach ($services as $service) {
                        $status = $service['state'] === 'RUNNING' ? '🟢' : '🔴';
                        $this->line("  {$status} {$service['service_name']} ({$service['service_type']}) - {$service['state']}");
                        
                        if ($service['service_type'] === 'mysql') {
                            $this->line("    Host: {$service['service_uri_params']['host']}:{$service['service_uri_params']['port']}");
                            $this->line("    Database: {$service['service_uri_params']['dbname']}");
                        }
                    }
                }
                
            } else {
                $this->error('❌ Aiven API Connection: FAILED');
                $this->error('Response: ' . $response->body());
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error connecting to Aiven API: ' . $e->getMessage());
            return 1;
        }

        $this->line('');
        $this->info('🎉 Aiven integration is working correctly!');
        return 0;
    }
}