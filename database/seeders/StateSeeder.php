<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Johor', 'abbreviation' => 'JHR'],
            ['name' => 'Kedah', 'abbreviation' => 'KDH'],
            ['name' => 'Kelantan', 'abbreviation' => 'KTN'],
            ['name' => 'Melaka', 'abbreviation' => 'MLK'],
            ['name' => 'Negeri Sembilan', 'abbreviation' => 'NSN'],
            ['name' => 'Pahang', 'abbreviation' => 'PHG'],
            ['name' => 'Pulau Pinang', 'abbreviation' => 'PNG'],
            ['name' => 'Perak', 'abbreviation' => 'PRK'],
            ['name' => 'Perlis', 'abbreviation' => 'PLS'],
            ['name' => 'Sabah', 'abbreviation' => 'SBH'],
            ['name' => 'Sarawak', 'abbreviation' => 'SWK'],
            ['name' => 'Selangor', 'abbreviation' => 'SGR'],
            ['name' => 'Terengganu', 'abbreviation' => 'TRG'],
            ['name' => 'Kuala Lumpur', 'abbreviation' => 'KUL'],
            ['name' => 'Labuan', 'abbreviation' => 'LBN'],
            ['name' => 'Putrajaya', 'abbreviation' => 'PJY'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
