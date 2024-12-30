<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $educations = ['Graduate School', 'University', 'High School', 'Others', "Unknown"];

        $i = 1;
        foreach ($educations as $eduation) {
            DB::table('educations')->insert([
                "id" => $i,
                'name' => $eduation,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $i++;
        }
    }
}
