<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class ComputersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('computers')->insert([
                'computer_name' => $faker->word . ' PC',
                'model' => $faker->word . ' Model',
                'operating_system' => $faker->randomElement(['Windows 10 Pro', 'Windows 11 Home', 'Ubuntu 22.04']), // [cite: 5]
                'processor' => $faker->randomElement(['Intel Core i5-11400', 'Intel Core i7-12700']), // [cite: 6]
                'memory' => $faker->randomElement([10, 20, 10]),
                'available' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
