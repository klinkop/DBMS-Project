<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name')->unique(); // Template name
            $table->text('subject'); // Subject line for the email
            $table->text('content'); // HTML or plain text content of the email
            $table->unsignedBigInteger('created_by'); // User ID of the creator
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint to reference users table (if you have a users table)
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users') // Assuming there is a 'users' table
                  ->onDelete('cascade'); // Optional: delete templates if user is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            // Drop foreign key before dropping the table
            $table->dropForeign(['created_by']);
        });

        Schema::dropIfExists('templates');
    }
}

