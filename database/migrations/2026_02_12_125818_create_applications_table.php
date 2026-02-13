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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->integer('user_id');
            $table->integer('resume_id');
            $table->text('cover_letter')->nullable();
            $table->string('status')->nullable();
            $table->date('applied_at')->nullable();
            $table->date('reviewd_at')->nullable();
            $table->text('employer_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
