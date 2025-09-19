<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->date('follow_up_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
            $table->dropColumn(['total_amount','paid_at','follow_up_at']);
        });
    }
};
