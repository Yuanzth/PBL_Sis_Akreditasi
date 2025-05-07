<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->string('id_user', 10)->primary();
            $table->string('id_level', 10);
            $table->string('username', 30)->unique();
            $table->string('nama', 100)->unique();
            $table->string('password', 15);
            $table->string('photo_profile', 255)->nullable();
            $table->foreign('id_level')->references('id_level')->on('m_level')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
