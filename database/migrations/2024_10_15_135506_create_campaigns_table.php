<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // References the creator (user)
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('email_subject');
            $table->text('email_body')->nullable(); // Email body can store the HTML content
            $table->text('sender_name');
            $table->text('status');
            $table->timestamp('scheduled_at')->nullable(); // When to send the emails
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
}
