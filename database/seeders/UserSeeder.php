<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->insert([
            ['name' => 'Admin Jakarta', 'email' => 'admin@jakarta.com', 'password' => bcrypt('password'), 'role' => 'admin', 'branch_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager Bandung', 'email' => 'manager@bandung.com', 'password' => bcrypt('password'), 'role' => 'manager', 'branch_id' => 2, 'created_at' => now(), 'updated_at' =>now()],
        ]);
    }
}
