<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_user')->insert([
            ['id_user' => '1', 'id_level' => '1', 'username' => 'Admin1', 'name' => 'Admin Kriteria 1', 'password' => Hash::make('12345')],
            ['id_user' => '2', 'id_level' => '1', 'username' => 'Admin2', 'name' => 'Admin Kriteria 2', 'password' => Hash::make('12345')],
            ['id_user' => '3', 'id_level' => '1', 'username' => 'Admin3', 'name' => 'Admin Kriteria 3', 'password' => Hash::make('12345')],
            ['id_user' => '4', 'id_level' => '1', 'username' => 'Admin4', 'name' => 'Admin Kriteria 4', 'password' => Hash::make('12345')],
            ['id_user' => '5', 'id_level' => '1', 'username' => 'Admin5', 'name' => 'Admin Kriteria 5', 'password' => Hash::make('12345')],
            ['id_user' => '6', 'id_level' => '1', 'username' => 'Admin6', 'name' => 'Admin Kriteria 6', 'password' => Hash::make('12345')],
            ['id_user' => '7', 'id_level' => '1', 'username' => 'Admin7', 'name' => 'Admin Kriteria 7', 'password' => Hash::make('12345')],
            ['id_user' => '8', 'id_level' => '1', 'username' => 'Admin8', 'name' => 'Admin Kriteria 8', 'password' => Hash::make('12345')],
            ['id_user' => '9', 'id_level' => '1', 'username' => 'Admin9', 'name' => 'Admin Kriteria 9', 'password' => Hash::make('12345')],
            ['id_user' => '10', 'id_level' => '2', 'username' => 'Kajur', 'name' => 'Ketua Jurusan', 'password' => Hash::make('12345')],
            ['id_user' => '11', 'id_level' => '2', 'username' => 'KPS', 'name' => 'Ketua Program Studi', 'password' => Hash::make('12345')],
            ['id_user' => '12', 'id_level' => '3', 'username' => 'KJM', 'name' => 'Kantor Jaminan Mutu', 'password' => Hash::make('12345')],
            ['id_user' => '13', 'id_level' => '4', 'username' => 'Direktur', 'name' => 'Direktur', 'password' => Hash::make('12345')],
        ]);
    }
}