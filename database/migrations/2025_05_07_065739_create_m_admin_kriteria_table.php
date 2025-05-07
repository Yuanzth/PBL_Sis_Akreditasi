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
        Schema::create('m_admin_kriteria', function (Blueprint $table) {
            $table->string('id_admin_kriteria', 10)->primary();
            $table->string('id_user', 10)->unique();
            $table->string('id_kriteria', 10);
            $table->foreign('id_user')->references('id_user')->on('m_user')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id_kriteria')->on('t_kriteria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_admin_kriteria');
    }
};
