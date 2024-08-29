<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Create root contacts
        for ($i = 0; $i < 10; $i++) {
            $parentId = null;

            // Create a contact
            DB::table('contacts')->insert([
                'name' => $faker->name,
                'SC' => $faker->word,
                'status' => $faker->word,
                'company' => $faker->company,
                'pic' => $faker->imageUrl(),
                'email' => $faker->email,
                'contact1' => $faker->phoneNumber,
                'contact2' => $faker->phoneNumber,
                'industry' => $faker->word,
                'city' => $faker->city,
                'state' => $faker->state,
                'parent_id' => $parentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create subfolders (contacts under root contacts)
        $rootContacts = DB::table('contacts')->whereNull('parent_id')->pluck('id');

        foreach ($rootContacts as $rootContactId) {
            for ($i = 0; $i < 5; $i++) {
                // Create a subfolder contact
                DB::table('contacts')->insert([
                    'name' => $faker->name,
                    'SC' => $faker->word,
                    'status' => $faker->word,
                    'company' => $faker->company,
                    'pic' => $faker->imageUrl(),
                    'email' => $faker->email,
                    'contact1' => $faker->phoneNumber,
                    'contact2' => $faker->phoneNumber,
                    'industry' => $faker->word,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'parent_id' => $rootContactId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Create sub-subfolders (contacts under subfolders)
        $subFolders = DB::table('contacts')->whereNotNull('parent_id')->pluck('id');

        foreach ($subFolders as $subFolderId) {
            for ($i = 0; $i < 3; $i++) {
                // Create a sub-subfolder contact
                DB::table('contacts')->insert([
                    'name' => $faker->name,
                    'SC' => $faker->word,
                    'status' => $faker->word,
                    'company' => $faker->company,
                    'pic' => $faker->imageUrl(),
                    'email' => $faker->email,
                    'contact1' => $faker->phoneNumber,
                    'contact2' => $faker->phoneNumber,
                    'industry' => $faker->word,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'parent_id' => $subFolderId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
