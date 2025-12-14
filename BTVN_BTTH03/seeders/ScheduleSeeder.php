<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedules')->insert([
            [
                'classroom_id' => 1,
                'course_name' => 'Cơ sở dữ liệu',
                'day_of_week' => 'Thứ Hai',
                'time_slot' => '08:00 - 10:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
