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
        Schema::table('save_jobs', function (Blueprint $table) {
            $table->integer('is_active')->after('job_id')->default(1);
            $table->foreignId('user_id')->change()->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->change()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('save_jobs', function (Blueprint $table) {
            // 1. Drop the foreign key constraints first
            $table->dropForeign(['user_id']);
            $table->dropForeign(['job_id']);
            $table->dropColumn('is_active');
        });
    }
};
