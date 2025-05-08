<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_level' => 1, 'level_kode' => 'Admin', 'level_nama' => 'Admin'],
            ['id_level' => 2, 'level_kode' => 'KPS_Kajur', 'level_nama' => 'KPS, Kajur'],
            ['id_level' => 3, 'level_kode' => 'KJM', 'level_nama' => 'KJM'],
            ['id_level' => 4, 'level_kode' => 'Direktur', 'level_nama' => 'Direktur'],
        ];

        DB::table('m_level')->insert($data);
    }
}