<?php

namespace Database\Seeders;

use App\Models\EmailList;
use Illuminate\Database\Seeder;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        EmailList::create([
            'campaign_id' => 1, // Assuming there is a campaign with ID 1
            'list_name' => 'Newsletter Subscribers',
        ]);

        // Add more email lists if needed
        EmailList::create([
            'campaign_id' => 2, // Assuming there is a campaign with ID 2
            'list_name' => 'Promotional Emails',
        ]);
    }
}

