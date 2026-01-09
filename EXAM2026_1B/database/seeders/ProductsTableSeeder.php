<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'store_id' => $faker->numberBetween(1, 10),
                'name' => $faker->name,
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2, 60, 70), // nbMaxDecimals lam tron 2 so thap phan
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
