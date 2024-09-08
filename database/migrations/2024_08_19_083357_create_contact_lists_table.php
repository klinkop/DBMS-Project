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
            $table->string('name')->nullable(); // Allow null values
            $table->string('status')->nullable(); // Allow null values
            $table->string('company')->nullable(); // Allow null values
            $table->string('pic')->nullable(); // Allow null values
            $table->string('email')->nullable(); // Allow null values
            $table->string('contact1')->nullable(); // Allow null values
            $table->string('contact2')->nullable(); // Allow null values
            $table->string('industry')->nullable(); // Allow null values
            $table->unsignedBigInteger('city_id')->nullable(); // Allow null values
            $table->unsignedBigInteger('state_id')->nullable(); // Allow null values
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
