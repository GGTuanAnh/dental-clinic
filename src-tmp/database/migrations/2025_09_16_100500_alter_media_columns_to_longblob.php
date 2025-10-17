<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $driver = config('database.default');
        if ($driver !== 'mysql') return; // Only apply for MySQL

        DB::statement('ALTER TABLE banners MODIFY image LONGBLOB NULL');
        DB::statement('ALTER TABLE services MODIFY image LONGBLOB NULL');
        DB::statement('ALTER TABLE doctors MODIFY photo LONGBLOB NULL');
    }

    public function down(): void
    {
        $driver = config('database.default');
        if ($driver !== 'mysql') return;

        DB::statement('ALTER TABLE banners MODIFY image BLOB NULL');
        DB::statement('ALTER TABLE services MODIFY image BLOB NULL');
        DB::statement('ALTER TABLE doctors MODIFY photo BLOB NULL');
    }
};
