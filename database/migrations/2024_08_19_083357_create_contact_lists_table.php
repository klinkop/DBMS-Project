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
        Schema::create('contact_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_folder_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status');
            $table->string('company');
            $table->string('pic');
            $table->string('email');
            $table->string('contact1');
            $table->string('contact2');
            $table->string('industry');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_lists');
    }
};
