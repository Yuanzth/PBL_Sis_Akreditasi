<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinalisasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_final_document')->insert([
            'id_user' => 1,
            'final_document' => 'Ini adalah isi dokumen finalisasi untuk kriteria 1. Data ini digunakan sebagai dummy untuk testing.'
        ]);
    }
}
