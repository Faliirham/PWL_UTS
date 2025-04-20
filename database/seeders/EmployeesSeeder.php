<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_employees')->insert([
            ['branch_id' => 1, 'position_id' => 2, 'name' => 'Andi', 'email' => 'andi@cafe.com', 'phone' => '08123456789', 'hire_date' => '2022-01-01', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['branch_id' => 2, 'position_id' => 2, 'name' => 'Budi', 'email' => 'budi@cafe.com', 'phone' => '08234567890', 'hire_date' => '2023-01-01', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
