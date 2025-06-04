<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateLevelSeeder extends Seeder
{
    public function run()
    {
        // Update level_id 1 menjadi SuperAdmin
        DB::table('m_level')->where('id_level', 1)->update([
            'level_kode' => 'SuperAdmin',
            'level_nama' => 'Super Administrator'
        ]);

        // Tambahkan level baru untuk Admin Kriteria (id_level 5-13)
        $adminLevels = [];
        for ($i = 5; $i <= 13; $i++) {
            $adminLevels[] = [
                'id_level' => $i,
                'level_kode' => 'Admin' . ($i - 4), // Admin5, Admin6, ..., Admin13
                'level_nama' => 'Admin Kriteria ' . ($i - 4)
            ];
        }
        DB::table('m_level')->insert($adminLevels);
    }
}