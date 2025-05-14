<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_komentar', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kriteria');
            $table->text('komentar');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id_user')->on('m_user');
            $table->foreign('id_kriteria')->references('id_kriteria')->on('m_kriteria');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_komentar');
    }
};