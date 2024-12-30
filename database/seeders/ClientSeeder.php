<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Create a Faker instance for Indonesian locale

        for ($i = 0; $i < 10; $i++) {
            DB::table('clients')->insert([
                'name' => $faker->name,
                'sex' => $faker->randomElement(['male', 'female']),
                'education_id' => rand(1, 5),
                'marriage_id' => rand(1, 3),
                'age' => rand(18, 70),
                'limit_bal' => $faker->randomFloat(2, 1000000, 100000000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
