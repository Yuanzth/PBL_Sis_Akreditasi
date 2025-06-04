<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserLevelSeeder extends Seeder
{
    public function run()
    {
        // Perbarui id_level untuk Admin1 hingga Admin9
        $adminUpdates = [
            ['id_user' => 1, 'id_level' => 5], // Admin1 → id_level 5
            ['id_user' => 2, 'id_level' => 6], // Admin2 → id_level 6
            ['id_user' => 3, 'id_level' => 7], // Admin3 → id_level 7
            ['id_user' => 4, 'id_level' => 8], // Admin4 → id_level 8
            ['id_user' => 5, 'id_level' => 9], // Admin5 → id_level 9
            ['id_user' => 6, 'id_level' => 10], // Admin6 → id_level 10
            ['id_user' => 7, 'id_level' => 11], // Admin7 → id_level 11
            ['id_user' => 8, 'id_level' => 12], // Admin8 → id_level 12
            ['id_user' => 9, 'id_level' => 13], // Admin9 → id_level 13
        ];

        foreach ($adminUpdates as $update) {
            DB::table('m_user')->where('id_user', $update['id_user'])->update(['id_level' => $update['id_level']]);
        }
    }
}