<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('students')->insert([
                'school_id' => $faker->numberBetween(1, 10),
                'full_name' => $faker->name(),
                'student_id' => $faker->unique()->name(),
                'email' => $faker->unique()->email(),
                'phone' => $faker->phoneNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
