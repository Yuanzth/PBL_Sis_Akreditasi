<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_kategori_kriteria', function (Blueprint $table) {
            $table->string('id_kategori_kriteria', 10)->primary();
            $table->string('nama_kriteria', 50); // Panjang disesuaikan dengan data maksimum seperti "Penetapan"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kategori_kriteria');
    }
};
