<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_user' => 1, 'id_level' => 1, 'username' => 'Farida', 'name' => 'Farida Ulfa, S.Pd., M.Pd.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 2, 'id_level' => 1, 'username' => 'Rakhmat', 'name' => 'Dr. Rakhmat Arianto, S.ST., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 3, 'id_level' => 1, 'username' => 'Vipkas', 'name' => 'Vipkas Al Hadid Firdaus, S.T, M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 4, 'id_level' => 1, 'username' => 'Laras', 'name' => 'Eka Larasati Amalia, S.ST., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 5, 'id_level' => 1, 'username' => 'Dimas', 'name' => 'Dimas Wahyu Wibowo, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 6, 'id_level' => 1, 'username' => 'Wida', 'name' => 'Dr. Widaningsih Condrowardhani, S.Psi., S.H., M.H.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 7, 'id_level' => 1, 'username' => 'Meyti', 'name' => 'Meyti Eka Apriyani, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 8, 'id_level' => 1, 'username' => 'Budi', 'name' => 'Budi Harijanto, S.T., M.MKom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 9, 'id_level' => 1, 'username' => 'Agung', 'name' => 'Agung Nugroho Pramudhita, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 10, 'id_level' => 1, 'username' => 'Atiqah', 'name' => 'Atiqah Nurul Asri, S.Pd., M.Pd.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 11, 'id_level' => 1, 'username' => 'Khairy', 'name' => 'Muhammad Shulhan Khairy, S.Kom., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 12, 'id_level' => 1, 'username' => 'Dika', 'name' => 'Dika Rizky Yunianto, S.Kom., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 13, 'id_level' => 1, 'username' => 'Vit', 'name' => 'Vit Zuraida, S.Kom., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 14, 'id_level' => 1, 'username' => 'Vivin', 'name' => 'Vivin Ayu Lestari, S.Pd., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 15, 'id_level' => 1, 'username' => 'Indra', 'name' => 'Dr. Indra Dharma Wijaya, S.T., M.MT.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 16, 'id_level' => 1, 'username' => 'Adevian', 'name' => 'Adevian Fairuz Pratama, S.S.T, M.Eng.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 17, 'id_level' => 1, 'username' => 'Zawa', 'name' => 'Moch. Zawaruddin Abdullah, S.ST., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 18, 'id_level' => 1, 'username' => 'Triana', 'name' => 'Triana Fatmawati, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 19, 'id_level' => 2, 'username' => 'Andrie', 'name' => 'Prof. Dr. Eng. Rosa Andrie Asmara, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 20, 'id_level' => 2, 'username' => 'Yoga', 'name' => 'Pramana Yoga Saputra, S.Kom., M.MT.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 21, 'id_level' => 2, 'username' => 'Hendra', 'name' => 'Hendra Pradibta, S.E., M.Sc.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 22, 'id_level' => 2, 'username' => 'Ely', 'name' => 'Dr. Ely Setyo Astuti, S.T., M.T.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 23, 'id_level' => 3, 'username' => 'Mungki', 'name' => 'Mungki Astiningrum, S.T., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 24, 'id_level' => 3, 'username' => 'Wilda', 'name' => 'Wilda Imama Sabilla, S.Kom., M.Kom.', 'password' => '12345', 'photo_profile' => null],
            ['id_user' => 25, 'id_level' => 4, 'username' => 'Supriatna', 'name' => 'Supriatna Adhisuwignjo S.T, M.T', 'password' => '12345', 'photo_profile' => null],
        ];

        DB::table('m_user')->insert($data);
    }
}