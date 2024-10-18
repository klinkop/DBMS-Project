<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailListsTable extends Migration
{
    public function up()
    {
        Schema::create('email_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('list_name'); // E.g., "Newsletter Subscribers", "Promotional Emails"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_lists');
    }
}

