<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add indexes for common queries
            $table->index(['status']);
            $table->index(['doctor_id']);
            $table->index(['appointment_at']);
            $table->index(['created_at']);
            $table->index(['status', 'doctor_id']);
            $table->index(['appointment_at', 'status']);
        });

        Schema::table('patients', function (Blueprint $table) {
            // Add indexes for patient searches
            $table->index(['phone']);
            $table->index(['created_at']);
        });

        Schema::table('services', function (Blueprint $table) {
            // Add index for active services
            $table->index(['created_at']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            // Add indexes for doctor queries
            $table->index(['user_id']);
            $table->index(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['doctor_id']);
            $table->dropIndex(['appointment_at']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['status', 'doctor_id']);
            $table->dropIndex(['appointment_at', 'status']);
        });

        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['phone']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['email']);
        });
    }
};
