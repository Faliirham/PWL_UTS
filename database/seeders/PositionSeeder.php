<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('m_positions')->insert([
            ['name' => 'Barista', 'description' => 'Membuat dan menyajikan kopi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kasir', 'description' => 'Melayani transaksi pembayaran', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'description' => 'Mengatur operasional cabang', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
