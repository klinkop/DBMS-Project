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
        Schema::table('contact_lists', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
            $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_lists', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['state_id']);
        });
    }
};
