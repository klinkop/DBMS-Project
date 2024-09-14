<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'A1'],
            ['name' => 'A2'],
            ['name' => 'Ongoing'],
        ];

        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
