<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $clients = [];

        for($i = 0; $i < 10; $i++) {
            $clients[] = [
                'name' => $faker->firstName,
                'email' => $faker->email,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('Client12.'),
                'role' => 'client'
            ];
        }

        DB::table('users')->insert($clients);
    }
}
