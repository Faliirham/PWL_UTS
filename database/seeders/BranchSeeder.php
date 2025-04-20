<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_branches')->insert([
            ['name' => 'Jakarta Branch', 'address' => 'Jl. Merdeka No.1', 'city' => 'Jakarta', 'phone' => '02112345678', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bandung Branch', 'address' => 'Jl. Braga No.10', 'city' => 'Bandung', 'phone' => '02298765432', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
