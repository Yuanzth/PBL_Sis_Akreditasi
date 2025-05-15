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
            KategoriKriteriaSeeder::class,
            DetailKriteriaSeeder::class,
            DataPendukungSeeder::class,
            KomentarSeeder::class,
            ValidasiSeeder::class,
        ]);
    }
}
