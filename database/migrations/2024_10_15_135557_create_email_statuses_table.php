<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('email_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade'); // References campaigns table
            $table->string('recipient_email'); // The email of the recipient
            $table->enum('status', ['pending', 'sent', 'failed']); // Status of the email
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_statuses');
    }
}
