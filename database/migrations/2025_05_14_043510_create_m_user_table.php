<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->unsignedBigInteger('id_level');
            $table->string('username', 30);
            $table->string('name', 30);
            $table->string('password', 255);
            $table->text('photo_profile')->nullable();
            
            $table->foreign('id_level')->references('id_level')->on('m_level');
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_user');
    }
};