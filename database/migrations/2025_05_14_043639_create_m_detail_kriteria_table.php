<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_detail_kriteria', function (Blueprint $table) {
            $table->id('id_detail_kriteria');
            $table->unsignedBigInteger('id_kriteria');
            $table->unsignedBigInteger('id_kategori_kriteria');
            
            $table->foreign('id_kriteria')->references('id_kriteria')->on('m_kriteria');
            $table->foreign('id_kategori_kriteria')->references('id_kategori_kriteria')->on('m_kategori_kriteria');
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_detail_kriteria');
    }
};