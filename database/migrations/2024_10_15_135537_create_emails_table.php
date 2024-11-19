<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_list_id')->constrained()->onDelete('cascade');
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email'); // Email address of the recipient
            $table->string('status')->default('pending'); // 'pending', 'sent', 'failed'
            $table->timestamp('sent_at')->nullable(); // Timestamp when the email was sent
            $table->text('error_message')->nullable(); // Capture any errors during sending
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
