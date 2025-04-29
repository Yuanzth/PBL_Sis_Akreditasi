<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 20)->unique();
            $table->string('nama', 100);
            $table->string('password');
            $table->unsignedBigInteger('level_id'); // FK ke m_level
            $table->timestamps();

            // Foreign Key
            $table->foreign('level_id')->references('level_id')->on('m_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
