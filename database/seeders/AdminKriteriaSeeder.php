<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_admin_kriteria' => 1, 'id_user' => 1, 'id_kriteria' => 1],
            ['id_admin_kriteria' => 2, 'id_user' => 2, 'id_kriteria' => 2],
            ['id_admin_kriteria' => 3, 'id_user' => 3, 'id_kriteria' => 3],
            ['id_admin_kriteria' => 4, 'id_user' => 4, 'id_kriteria' => 4],
            ['id_admin_kriteria' => 5, 'id_user' => 5, 'id_kriteria' => 5],
            ['id_admin_kriteria' => 6, 'id_user' => 6, 'id_kriteria' => 6],
            ['id_admin_kriteria' => 7, 'id_user' => 7, 'id_kriteria' => 7],
            ['id_admin_kriteria' => 8, 'id_user' => 8, 'id_kriteria' => 8],
            ['id_admin_kriteria' => 9, 'id_user' => 9, 'id_kriteria' => 9],
            ['id_admin_kriteria' => 10, 'id_user' => 10, 'id_kriteria' => 10],
            ['id_admin_kriteria' => 11, 'id_user' => 11, 'id_kriteria' => 11],
            ['id_admin_kriteria' => 12, 'id_user' => 12, 'id_kriteria' => 12],
            ['id_admin_kriteria' => 13, 'id_user' => 13, 'id_kriteria' => 13],
            ['id_admin_kriteria' => 14, 'id_user' => 14, 'id_kriteria' => 14],
            ['id_admin_kriteria' => 15, 'id_user' => 15, 'id_kriteria' => 15],
            ['id_admin_kriteria' => 16, 'id_user' => 16, 'id_kriteria' => 16],
            ['id_admin_kriteria' => 17, 'id_user' => 17, 'id_kriteria' => 17],
            ['id_admin_kriteria' => 18, 'id_user' => 18, 'id_kriteria' => 18],
        ];

        DB::table('m_admin_kriteria')->insert($data);
    }
}