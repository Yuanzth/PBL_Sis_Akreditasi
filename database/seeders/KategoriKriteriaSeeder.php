<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKriteriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_kategori_kriteria')->insert([
            ['id_kategori_kriteria' => '1', 'nama_kategori' => 'Penetapan'],
            ['id_kategori_kriteria' => '2', 'nama_kategori' => 'Pelaksanaan'],
            ['id_kategori_kriteria' => '3', 'nama_kategori' => 'Evaluasi'],
            ['id_kategori_kriteria' => '4', 'nama_kategori' => 'Pengendalian'],
            ['id_kategori_kriteria' => '5', 'nama_kategori' => 'Peningkatan'],
        ]);
    }
}