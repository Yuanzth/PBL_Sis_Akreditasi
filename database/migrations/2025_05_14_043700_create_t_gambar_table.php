<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_gambar', function (Blueprint $table) {
            $table->id('id_gambar');
            $table->unsignedBigInteger('id_data_pendukung');
            $table->text('gambar');
            
            $table->foreign('id_data_pendukung')->references('id_data_pendukung')->on('t_data_pendukung');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_gambar');
    }
};