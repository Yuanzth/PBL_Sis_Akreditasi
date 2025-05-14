<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_kategori_kriteria', function (Blueprint $table) {
            $table->id('id_kategori_kriteria');
            $table->string('nama_kategori', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_kategori_kriteria');
    }
};