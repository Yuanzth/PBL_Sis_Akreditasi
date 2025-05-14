<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_level', function (Blueprint $table) {
            $table->id('id_level'); // Menggunakan method id() yang lebih aman
            $table->string('level_kode', 15);
            $table->string('level_nama', 30);
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_level');
    }
};