<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_performance')->insert([
            ['employee_id' => 1, 'evaluator_id' => 1, 'score' => 90, 'notes' => 'Excellent performance', 'evaluation_date' => '2024-01-10', 'created_at' => now(), 'updated_at' => now()],
            ['employee_id' => 2, 'evaluator_id' => 2, 'score' => 80, 'notes' => 'Good effort', 'evaluation_date' => '2024-02-15', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
