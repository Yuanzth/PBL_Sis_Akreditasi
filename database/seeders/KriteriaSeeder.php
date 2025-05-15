<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_kriteria')->insert([
            ['id_kriteria' => '1', 'id_user' => '1', 'nama_kriteria' => 'Kriteria 1'],
            ['id_kriteria' => '2', 'id_user' => '2', 'nama_kriteria' => 'Kriteria 2'],
            ['id_kriteria' => '3', 'id_user' => '3', 'nama_kriteria' => 'Kriteria 3'],
            ['id_kriteria' => '4', 'id_user' => '4', 'nama_kriteria' => 'Kriteria 4'],
            ['id_kriteria' => '5', 'id_user' => '5', 'nama_kriteria' => 'Kriteria 5'],
            ['id_kriteria' => '6', 'id_user' => '6', 'nama_kriteria' => 'Kriteria 6'],
            ['id_kriteria' => '7', 'id_user' => '7', 'nama_kriteria' => 'Kriteria 7'],
            ['id_kriteria' => '8', 'id_user' => '8', 'nama_kriteria' => 'Kriteria 8'],
            ['id_kriteria' => '9', 'id_user' => '9', 'nama_kriteria' => 'Kriteria 9'],
        ]);
    }
}