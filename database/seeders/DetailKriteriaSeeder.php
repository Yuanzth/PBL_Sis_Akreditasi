<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_detail_kriteria' => 1, 'id_kriteria' => 1, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 2, 'id_kriteria' => 1, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 3, 'id_kriteria' => 1, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 4, 'id_kriteria' => 1, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 5, 'id_kriteria' => 1, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 6, 'id_kriteria' => 2, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 7, 'id_kriteria' => 2, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 8, 'id_kriteria' => 2, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 9, 'id_kriteria' => 2, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 10, 'id_kriteria' => 2, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 11, 'id_kriteria' => 3, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 12, 'id_kriteria' => 3, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 13, 'id_kriteria' => 3, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 14, 'id_kriteria' => 3, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 15, 'id_kriteria' => 3, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 16, 'id_kriteria' => 4, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 17, 'id_kriteria' => 4, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 18, 'id_kriteria' => 4, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 19, 'id_kriteria' => 4, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 20, 'id_kriteria' => 4, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 21, 'id_kriteria' => 5, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 22, 'id_kriteria' => 5, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 23, 'id_kriteria' => 5, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 24, 'id_kriteria' => 5, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 25, 'id_kriteria' => 5, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 26, 'id_kriteria' => 6, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 27, 'id_kriteria' => 6, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 28, 'id_kriteria' => 6, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 29, 'id_kriteria' => 6, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 30, 'id_kriteria' => 6, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 31, 'id_kriteria' => 7, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 32, 'id_kriteria' => 7, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 33, 'id_kriteria' => 7, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 34, 'id_kriteria' => 7, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 35, 'id_kriteria' => 7, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 36, 'id_kriteria' => 8, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 37, 'id_kriteria' => 8, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 38, 'id_kriteria' => 8, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 39, 'id_kriteria' => 8, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 40, 'id_kriteria' => 8, 'id_kategori_kriteria' => 5],
            ['id_detail_kriteria' => 41, 'id_kriteria' => 9, 'id_kategori_kriteria' => 1],
            ['id_detail_kriteria' => 42, 'id_kriteria' => 9, 'id_kategori_kriteria' => 2],
            ['id_detail_kriteria' => 43, 'id_kriteria' => 9, 'id_kategori_kriteria' => 3],
            ['id_detail_kriteria' => 44, 'id_kriteria' => 9, 'id_kategori_kriteria' => 4],
            ['id_detail_kriteria' => 45, 'id_kriteria' => 9, 'id_kategori_kriteria' => 5],
        ];

        DB::table('m_detail_kriteria')->insert($data);
    }
}