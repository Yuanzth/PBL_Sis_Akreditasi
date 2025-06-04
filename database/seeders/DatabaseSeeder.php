<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seeder awal
        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            KategoriKriteriaSeeder::class,
            KriteriaSeeder::class,
            DetailKriteriaSeeder::class,
            DataPendukungSeeder::class,
            KomentarSeeder::class,
            ValidasiSeeder::class,
            FinalisasiSeeder::class,
        ]);

        // Seeder baru untuk update
        $this->call([
            UpdateLevelSeeder::class,
            UpdateUserLevelSeeder::class,
            UpdateKriteriaLevelSeeder::class,
            AddSuperAdminSeeder::class,
        ]);
    }
}