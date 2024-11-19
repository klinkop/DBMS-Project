<?php

// database/migrations/2024_xx_xx_create_email_templates_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable(); // Stores the HTML content of the template
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('email_templates');
    }
};
