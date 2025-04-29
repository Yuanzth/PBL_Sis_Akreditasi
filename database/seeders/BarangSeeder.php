<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Biskuit', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Roti', 'harga_beli' => 5000, 'harga_jual' => 7000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Teh Botol', 'harga_beli' => 2000, 'harga_jual' => 3000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Kopi Instan', 'harga_beli' => 3000, 'harga_jual' => 4000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Mouse Wireless', 'harga_beli' => 100000, 'harga_jual' => 150000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Keyboard Mechanical', 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Sapu', 'harga_beli' => 15000, 'harga_jual' => 20000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Pel', 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 40000, 'harga_jual' => 50000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Jaket Hoodie', 'harga_beli' => 100000, 'harga_jual' => 120000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
