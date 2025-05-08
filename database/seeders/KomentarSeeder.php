<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KomentarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_komentar' => 1, 'id_user' => 20, 'id_data_pendukung' => 4, 'komentar' => 'tidak tepat'],
            ['id_komentar' => 2, 'id_user' => 21, 'id_data_pendukung' => 4, 'komentar' => 'kurang mantap'],
            ['id_komentar' => 3, 'id_user' => 19, 'id_data_pendukung' => 14, 'komentar' => 'data tidak lengkap'],
            ['id_komentar' => 4, 'id_user' => 22, 'id_data_pendukung' => 20, 'komentar' => 'Spasi antar baris tidak konsisten.'],
            ['id_komentar' => 5, 'id_user' => 20, 'id_data_pendukung' => 14, 'komentar' => 'salah file'],
            ['id_komentar' => 6, 'id_user' => 22, 'id_data_pendukung' => 33, 'komentar' => 'format tidak sesuai'],
            ['id_komentar' => 7, 'id_user' => 19, 'id_data_pendukung' => 41, 'komentar' => 'terlalu banyak typo'],
            ['id_komentar' => 8, 'id_user' => 22, 'id_data_pendukung' => 14, 'komentar' => 'Tidak terdapat header/footer sesuai pedoman'],
            ['id_komentar' => 9, 'id_user' => 21, 'id_data_pendukung' => 7, 'komentar' => 'Margin dokumen tidak sesuai standar.'],
            ['id_komentar' => 10, 'id_user' => 20, 'id_data_pendukung' => 2, 'komentar' => 'Penulisan judul tidak konsisten'],
        ];

        DB::table('t_komentar')->insert($data);
    }
}