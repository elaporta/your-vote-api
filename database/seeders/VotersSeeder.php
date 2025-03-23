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
                'document' => $this->generateValidUruguayanCedula(),
                'dob' => $faker->dateTimeBetween('-100 years', '-18 years'),
                'address' => $faker->streetAddress,
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'is_candidate' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('voters')->insert($voters);
    }

    private function generateValidUruguayanCedula()
    {
        // Generate first 7 random digits
        $base = str_pad(rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        
        // Weights for the calculation
        $weights = [2, 9, 8, 7, 6, 3, 4];
        $sum = 0;

        // Apply the Module 10 algorithm
        for($i = 0; $i < 7; $i++) {
            $sum += (int) $base[$i] * $weights[$i];
        }

        // Compute the check digit
        $checkDigit = (10 - ($sum % 10)) % 10;

        // Return formatted Cédula
        return $base . $checkDigit;
    }
}
