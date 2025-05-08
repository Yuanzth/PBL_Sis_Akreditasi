<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_kategori_kriteria' => 1, 'nama_kriteria' => 'Penetapan'],
            ['id_kategori_kriteria' => 2, 'nama_kriteria' => 'Pelaksanaan'],
            ['id_kategori_kriteria' => 3, 'nama_kriteria' => 'Evaluasi'],
            ['id_kategori_kriteria' => 4, 'nama_kriteria' => 'Pengendalian'],
            ['id_kategori_kriteria' => 5, 'nama_kriteria' => 'Peningkatan'],
        ];

        DB::table('t_kategori_kriteria')->insert($data);
    }
}