<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $computerIds = DB::table('computers')->pluck('id')->toArray();
        foreach (range(1, 50) as $index) { // Đảm bảo tối thiểu 50 bản ghi 
            DB::table('issues')->insert([
                'computer_id' => $faker->randomElement($computerIds), // Khóa ngoại 
                'reported_by' => $faker->name, // Người báo cáo [cite: 11]
                'reported_date' => $faker->dateTimeThisYear(), // Thời gian báo cáo [cite: 12]
                'description' => $faker->paragraph, // Mô tả chi tiết [cite: 13]
                'urgency' => $faker->randomElement(['Low', 'Medium', 'High']), // Mức độ [cite: 14]
                'status' => $faker->randomElement(['Open', 'In Progress', 'Resolved']), // Trạng thái [cite: 15]
                'created_at' => now(),
                'updated_at' => now(),
            ]);



        }
    }
}
