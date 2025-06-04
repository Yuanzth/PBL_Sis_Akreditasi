<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddSuperAdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('m_user')->insert([
            'id_user' => 14,
            'id_level' => 1,
            'username' => 'SuperAdmin',
            'name' => 'Super Administrator',
            'password' => Hash::make('superadmin123'),
            'photo_profile' => NULL
        ]);
    }
}