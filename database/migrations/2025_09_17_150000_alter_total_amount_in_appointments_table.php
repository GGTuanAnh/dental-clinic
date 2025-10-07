<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any NULL values to 0
        DB::statement('UPDATE appointments SET total_amount = 0 WHERE total_amount IS NULL');
        
        // Then normalize total_amount column to DECIMAL(12,2) NOT NULL DEFAULT 0
        // Using raw SQL to avoid requiring doctrine/dbal for change()
        DB::statement('ALTER TABLE appointments MODIFY total_amount DECIMAL(12,2) NOT NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best-effort rollback: revert to DECIMAL(10,2) NULL (adjust if original differs)
        DB::statement('ALTER TABLE appointments MODIFY total_amount DECIMAL(10,2) NULL');
    }
};
