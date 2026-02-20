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
        Schema::table('company_socials', function (Blueprint $table) {
            // add FK with cascade delete
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_socials', function (Blueprint $table) {
            $table->dropForeign(['company_id']);

            // restore without cascade (RESTRICT)
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
        });
    }
};
