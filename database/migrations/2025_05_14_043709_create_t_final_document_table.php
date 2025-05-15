<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('t_final_document', function (Blueprint $table) {
            $table->id('id_final_document');
            $table->unsignedBigInteger('id_user');
            $table->text('final_document');
            
            $table->foreign('id_user')->references('id_user')->on('m_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_final_document');
    }
};