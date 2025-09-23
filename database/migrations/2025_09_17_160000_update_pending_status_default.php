<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::table('appointments')
            ->where('status', 'scheduled')
            ->update(['status' => 'pending']);

        $driver = Schema::getConnection()->getDriverName();
        try {
            if (in_array($driver, ['mysql', 'mariadb'])) {
                DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(255) NOT NULL DEFAULT 'pending'");
            } elseif ($driver === 'pgsql') {
                DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'pending'");
            }
        } catch (\Throwable $e) {
            // If the platform doesn't support altering the default via the above SQL
            // (e.g. sqlite), we gracefully skip without failing the migration.
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        try {
            if (in_array($driver, ['mysql', 'mariadb'])) {
                DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(255) NOT NULL DEFAULT 'scheduled'");
            } elseif ($driver === 'pgsql') {
                DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'scheduled'");
            }
        } catch (\Throwable $e) {
            // noop
        }

        DB::table('appointments')
            ->where('status', 'pending')
            ->whereNull('doctor_id')
            ->whereNull('paid_at')
            ->update(['status' => 'scheduled']);
    }
};
