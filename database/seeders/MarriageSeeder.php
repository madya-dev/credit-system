<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarriageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $marriages = ['Married', 'Single', 'Others'];

        $i = 1;
        foreach ($marriages as $marriage) {
            DB::table('marriages')->insert([
                "id" => $i,
                'name' => $marriage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $i++;
        }
    }
}
