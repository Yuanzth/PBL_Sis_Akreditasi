<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            KriteriaSeeder::class,
            DetailKriteriaSeeder::class,
            AdminKriteriaSeeder::class,
            KategoriKriteriaSeeder::class,
            DataPendukungSeeder::class,
            KomentarSeeder::class,
            ValidasiSeeder::class,
        ]);
    }
}
