<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AivenConfig extends Command
{
    protected $signature = 'aiven:config';
    protected $description = 'Show detailed Aiven configuration and service details';

    public function handle()
    {
        $token = env('AIVEN_API_TOKEN');
        $project = env('AIVEN_PROJECT_NAME');

        if (!$token || !$project) {
            $this->error('❌ Aiven configuration not found in .env');
            return 1;
        }

        $this->info('☁️ AIVEN CLOUD CONFIGURATION');
        $this->info('==============================');
        $this->line('');

        try {
            // Project Details
            $projectResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])
            ->withOptions(['verify' => false])
            ->get("https://api.aiven.io/v1/project/{$project}");

            if ($projectResponse->successful()) {
                $projectInfo = $projectResponse->json()['project'];
                
                $this->info('🏗️ PROJECT DETAILS:');
                $this->line('  Name: ' . $projectInfo['project_name']);
                $this->line('  Description: ' . ($projectInfo['description'] ?? 'N/A'));
                $this->line('  Country: ' . $projectInfo['country_code']);
                $this->line('  Default Cloud: ' . $projectInfo['default_cloud']);
                $this->line('  Created: ' . ($projectInfo['create_time'] ?? 'N/A'));
                $this->line('');

                // Services Details
                $servicesResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->withOptions(['verify' => false])
                ->get("https://api.aiven.io/v1/project/{$project}/service");

                if ($servicesResponse->successful()) {
                    $services = $servicesResponse->json()['services'];
                    
                    $this->info('🗄️ SERVICES DETAILS:');
                    $this->line('Total services: ' . count($services));
                    $this->line('');

                    foreach ($services as $service) {
                        $status = $service['state'] === 'RUNNING' ? '🟢 RUNNING' : '🔴 ' . $service['state'];
                        
                        $this->line("📊 {$service['service_name']} ({$service['service_type']})");
                        $this->line("  Status: {$status}");
                        $this->line("  Plan: " . ($service['plan'] ?? 'N/A'));
                        $this->line("  Cloud: " . ($service['cloud_name'] ?? 'N/A'));
                        $this->line("  Region: " . ($service['cloud_region'] ?? 'N/A'));
                        $this->line("  Created: " . ($service['create_time'] ?? 'N/A'));
                        
                        if ($service['service_type'] === 'mysql') {
                            $uri = $service['service_uri_params'];
                            $this->line('');
                            $this->line('  🔗 CONNECTION DETAILS:');
                            $this->line("    Host: " . ($uri['host'] ?? 'N/A'));
                            $this->line("    Port: " . ($uri['port'] ?? 'N/A'));
                            $this->line("    Database: " . ($uri['dbname'] ?? 'N/A'));
                            $this->line("    Username: " . ($uri['user'] ?? 'N/A'));
                            $this->line("    SSL Mode: " . ($uri['sslmode'] ?? 'required'));
                            
                            // Node info
                            if (isset($service['node_states'])) {
                                $this->line('');
                                $this->line('  🖥️ NODES:');
                                foreach ($service['node_states'] as $node) {
                                    $nodeStatus = $node['state'] === 'running' ? '🟢' : '🔴';
                                    $this->line("    {$nodeStatus} {$node['name']} ({$node['role']}) - {$node['state']}");
                                }
                            }

                            // Metrics
                            if (isset($service['metadata'])) {
                                $this->line('');
                                $this->line('  📈 METRICS:');
                                $this->line("    CPU Usage: " . ($service['node_cpu_usage_percent'] ?? 'N/A') . '%');
                                $this->line("    Memory Usage: " . ($service['node_memory_usage_percent'] ?? 'N/A') . '%');
                                $this->line("    Disk Usage: " . ($service['disk_usage_percent'] ?? 'N/A') . '%');
                            }
                        }
                        $this->line('');
                    }
                }

                // API Token Info
                $this->info('🔑 API CONFIGURATION:');
                $this->line('  Token: ***' . substr($token, -10));
                $this->line('  Project: ' . $project);
                $this->line('  API Base: https://api.aiven.io/v1');
                $this->line('');

                // Local .env Configuration
                $this->info('⚙️ LOCAL CONFIGURATION (.env):');
                $this->line('  AIVEN_API_TOKEN: Set');
                $this->line('  AIVEN_PROJECT_NAME: ' . $project);
                $this->line('  DB_HOST: ' . env('DB_HOST'));
                $this->line('  DB_PORT: ' . env('DB_PORT'));
                $this->line('  DB_DATABASE: ' . env('DB_DATABASE'));
                $this->line('  DB_USERNAME: ' . env('DB_USERNAME'));
                $this->line('  DB_SSLMODE: ' . env('DB_SSLMODE'));
                
            } else {
                $this->error('❌ Failed to fetch Aiven configuration');
                $this->error('Response: ' . $projectResponse->body());
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }

        $this->line('');
        $this->info('✅ Aiven configuration displayed successfully!');
        return 0;
    }
}