<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VotersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $voters = [];

        for($i = 0; $i < 10; $i++) {
            $voters[] = [
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'document' => $faker->numerify('########'),
                'dob' => $faker->dateTimeBetween('-100 years', '-18 years'),
                'is_candidate' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('voters')->insert($voters);
    }
}
