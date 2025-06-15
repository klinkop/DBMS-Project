<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Raw'],
            ['name' => 'Ongoing'],
            ['name' => 'Potential'],
            ['name' => 'Existing'],
            ['name' => 'KL-TG Raw'],
            ['name' => 'KL-TG Ongoing'],
            ['name' => 'KL-TG Potential'],
            ['name' => 'KL-TG Existing'],
            ['id' => 999, 'name' => 'Others'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
