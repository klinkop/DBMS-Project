<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailBodyColumnsToCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Adding two new columns
            $table->text('email_body_json')->nullable();  // JSON content column
            $table->longText('email_body_html')->nullable(); // HTML content column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Dropping the columns if the migration is rolled back
            $table->dropColumn(['email_body_json', 'email_body_html']);
        });
    }
}
