<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_data_pendukung', function (Blueprint $table) {
            $table->id('id_data_pendukung');
            $table->unsignedBigInteger('id_detail_kriteria');
            $table->text('deskripsi_data');
            $table->text('nama_data');
            $table->text('hyperlink_data')->nullable();
            $table->boolean('draft')->default(true);
            $table->timestamps();
            
            $table->foreign('id_detail_kriteria')->references('id_detail_kriteria')->on('m_detail_kriteria');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_data_pendukung');
    }
};