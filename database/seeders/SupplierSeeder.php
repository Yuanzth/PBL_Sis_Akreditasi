<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_supplier = [
            [
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT Indomarco Prismatama',
                'supplier_alamat' => 'Jl. Ancol Barat IV No. 1, Jakarta Utara',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'PT Sumber Alfaria Trijaya',
                'supplier_alamat' => 'Jl. MH. Thamrin No. 9, Tangerang',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'PT Mayora Indah Tbk',
                'supplier_alamat' => 'Jl. Daan Mogot KM 18, Jakarta Barat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('m_supplier')->insert($data_supplier);
    }
}
