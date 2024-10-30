<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        Campaign::create([
            'user_id' => 1, // Adjust this based on your users
            'name' => 'Test Campaign',
            'description' => 'This is a test campaign.',
            'email_subject' => 'Welcome to Our Service',
            'email_body' => '<h1>Hello!</h1><p>Thank you for joining us.</p>',
            'scheduled_at' => now(),
        ]);
    }
}
