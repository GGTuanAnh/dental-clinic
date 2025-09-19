<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed core demo data for local run
        $this->call([
            ServicesSeeder::class,
            DoctorsSeeder::class,
            BannersSeeder::class,
        ]);
    }
}
