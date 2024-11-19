<?php

namespace Database\Seeders;

use App\Models\EmailStatus;
use Illuminate\Database\Seeder;

class EmailStatusSeeder extends Seeder
{
    public function run()
    {
        EmailStatus::create([
            'campaign_id' => 1, // Assuming there is a campaign with ID 1
            'recipient_email' => 'recipient1@example.com',
            'status' => 'pending',
        ]);

        // Add more email statuses if needed
        EmailStatus::create([
            'campaign_id' => 1,
            'recipient_email' => 'recipient2@example.com',
            'status' => 'pending',
        ]);
    }
}

