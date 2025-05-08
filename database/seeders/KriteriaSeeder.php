<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_kriteria' => 1, 'nama_kriteria' => 'Kriteria 1'],
            ['id_kriteria' => 2, 'nama_kriteria' => 'Kriteria 2'],
            ['id_kriteria' => 3, 'nama_kriteria' => 'Kriteria 3'],
            ['id_kriteria' => 4, 'nama_kriteria' => 'Kriteria 4'],
            ['id_kriteria' => 5, 'nama_kriteria' => 'Kriteria 5'],
            ['id_kriteria' => 6, 'nama_kriteria' => 'Kriteria 6'],
            ['id_kriteria' => 7, 'nama_kriteria' => 'Kriteria 7'],
            ['id_kriteria' => 8, 'nama_kriteria' => 'Kriteria 8'],
            ['id_kriteria' => 9, 'nama_kriteria' => 'Kriteria 9'],
        ];

        DB::table('t_kriteria')->insert($data);
    }
}