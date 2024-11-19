<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    public function run()
    {
        Email::create([
            'email_list_id' => 1, // Assuming there is an email list with ID 1
            'recipient_name' => 'John Doe',
            'recipient_email' => 'john@example.com',
            'status' => 'pending',
            'sent_at' => null,
            'error_message' => null,
        ]);

        // Add more emails if needed
        Email::create([
            'email_list_id' => 1,
            'recipient_name' => 'Jane Smith',
            'recipient_email' => 'jane@example.com',
            'status' => 'pending',
            'sent_at' => null,
            'error_message' => null,
        ]);
    }
}

