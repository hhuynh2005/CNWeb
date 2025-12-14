<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            [
                'room_number' => 'A101',
                'capacity' => 50,
                'building' => 'Tòa nhà A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 'B202',
                'capacity' => 40,
                'building' => 'Tòa nhà B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
