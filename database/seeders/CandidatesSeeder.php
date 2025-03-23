<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $candidates = [];

        for($i = 0; $i < 2; $i++) {
            $candidates[] = [
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'document' => $faker->numerify('########'),
                'dob' => $faker->dateTimeBetween('-100 years', '-18 years'),
                'is_candidate' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('voters')->insert($candidates);
    }
}
