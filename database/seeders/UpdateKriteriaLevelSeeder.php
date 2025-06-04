<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateKriteriaLevelSeeder extends Seeder
{
    public function run()
    {
        // Mapping id_user lama ke id_level baru
        $mapping = [
            1 => 5,  // id_user=1 → id_level=5
            2 => 6,  // id_user=2 → id_level=6
            3 => 7,  // id_user=3 → id_level=7
            4 => 8,  // id_user=4 → id_level=8
            5 => 9,  // id_user=5 → id_level=9
            6 => 10, // id_user=6 → id_level=10
            7 => 11, // id_user=7 → id_level=11
            8 => 12, // id_user=8 → id_level=12
            9 => 13  // id_user=9 → id_level=13
        ];

        // Perbarui id_level di m_kriteria berdasarkan id_user
        foreach ($mapping as $id_kriteria => $id_level) {
            DB::table('m_kriteria')
                ->where('id_kriteria', $id_kriteria)
                ->update(['id_level' => $id_level]);
        }
    }
}