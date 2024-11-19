<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::create([
            'name' => 'Welcome Email',
            'subject' => 'Welcome to Our Service!',
            'content' => '<h1>Welcome!</h1><p>Thank you for joining us.</p>',
            'created_by' => 1, // Assuming the user ID is 1 for the Admin User
        ]);

        // Add more templates if needed
        Template::create([
            'name' => 'Newsletter',
            'subject' => 'Monthly Newsletter',
            'content' => '<h1>Latest News</h1><p>Check out our updates.</p>',
            'created_by' => 1,
        ]);
    }
}


