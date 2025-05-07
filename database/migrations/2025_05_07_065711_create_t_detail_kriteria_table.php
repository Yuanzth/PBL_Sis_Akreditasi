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
        Schema::create('t_detail_kriteria', function (Blueprint $table) {
            $table->string('id_detail_kriteria', 10)->primary();
            $table->string('id_kriteria', 10);
            $table->string('id_kategori_kriteria', 10);
            $table->foreign('id_kriteria')->references('id_kriteria')->on('t_kriteria')->onDelete('cascade');
            $table->foreign('id_kategori_kriteria')->references('id_kategori_kriteria')->on('t_kategori_kriteria')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detail_kriteria');
    }
};
