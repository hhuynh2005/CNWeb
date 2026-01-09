<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('schools')->insert([
                'name' => $faker->unique()->name(),
                'principal' => $faker->name(),
                'address' => $faker->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
