<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_generated_document', function (Blueprint $table) {
            $table->id('id_generated_document');
            $table->unsignedBigInteger('id_kriteria');
            $table->text('generated_document');
            
            $table->foreign('id_kriteria')->references('id_kriteria')->on('m_kriteria');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_generated_document');
    }
};