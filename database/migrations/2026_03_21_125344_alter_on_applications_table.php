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
        Schema::table('applications', function (Blueprint $table) {
            // Change column type
            $table->unsignedBigInteger('job_id')->change();
            $table->unsignedBigInteger('resume_id')->change();
            $table->unsignedBigInteger('user_id')->change();
            // To add foreign key manually
            $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
            $table->foreign('resume_id')->references('id')->on('resumes')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropForeign(['resume_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
