<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        Schedule::create([
            'campaign_id' => 1, // Assuming there is a campaign with ID 1
            'scheduled_time' => now()->addDays(1), // Schedule for one day later
        ]);

        // Add more schedules if needed
        Schedule::create([
            'campaign_id' => 2, // Assuming there is a campaign with ID 2
            'scheduled_time' => now()->addDays(2),
        ]);
    }
}

