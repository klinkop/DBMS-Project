<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\EmailListSeeder as SeedersEmailListSeeder;
use Database\Seeders\EmailSeeder as SeedersEmailSeeder;
use Database\Seeders\ScheduleSeeder as SeedersScheduleSeeder;
use Database\Seeders\TemplateSeeder;
use Database\Seeders\EmailStatusSeeder;
use EmailListSeeder;
use EmailSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ScheduleSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(ContactsTableSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TypeSeeder::class);

        $this->call(CampaignSeeder::class);
        $this->call(TemplateSeeder::class);
        // $this->call(SeedersScheduleSeeder::class);
        // $this->call(EmailStatusSeeder::class);
        // $this->call(SeedersEmailListSeeder::class);
        // $this->call(SeedersEmailSeeder::class);

    }
}
