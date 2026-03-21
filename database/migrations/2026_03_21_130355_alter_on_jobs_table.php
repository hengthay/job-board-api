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
        Schema::table('jobs', function (Blueprint $table) {
            // Change column type
            $table->unsignedBigInteger('company_id')->change();
            $table->unsignedBigInteger('job_category_id')->nullable()->change();
            $table->unsignedBigInteger('job_type_id')->nullable()->change();
            // To add foreign key manually
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->foreign('job_category_id')->references('id')->on('job_categories')->nullOnDelete();
            $table->foreign('job_type_id')->references('id')->on('job_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['job_category_id']);
            $table->dropForeign(['job_type_id']);
        });
    }
};
