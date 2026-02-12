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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('job_category_id');
            $table->integer('job_type_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('requirements')->nullable();
            $table->json('benefits')->nullable();
            $table->string('location')->nullable();
            $table->string('work_mode')->nullable();
            $table->decimal('salary_min', 8, 2)->nullable();
            $table->decimal('salary_max', 8, 2)->nullable();
            $table->integer('vacancies'); // Available for the position
            $table->date('deadline');
            $table->string('status')->default('Open');
            $table->date('published')->nullable();
            $table->date('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
