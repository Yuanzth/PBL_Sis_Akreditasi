<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_kriteria', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_kriteria', 100);
            
            $table->foreign('id_user')->references('id_user')->on('m_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_kriteria');
    }
};