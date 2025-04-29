<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) { // 10 transaksi
            for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                $barang_id = rand(1, 10);
                $harga = DB::table('m_barang')->where('barang_id', $barang_id)->value('harga_jual');
                $jumlah = rand(1, 5);

                $data[] = [
                    'detail_id' => count($data) + 1,
                    'penjualan_id' => $i,
                    'barang_id' => $barang_id,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
