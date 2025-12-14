<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'name' => 'Hệ thống quản lý khách hàng',
                'start_date' => '2024-11-01',
                'end_date' => '2025-02-01',
                'budget' => 50000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
