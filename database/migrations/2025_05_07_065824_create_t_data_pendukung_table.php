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
        Schema::create('t_data_pendukung', function (Blueprint $table) {
            $table->string('id_data_pendukung', 10)->primary();
            $table->string('id_detail_kriteria', 10);
            $table->text('deskripsi_data');
            $table->string('nama_data', 100);
            $table->string('hyperlink_data', 255);
            $table->enum('status_validasi', ['0', '1'])->default('0'); // Sesuaikan nilai ENUM
            $table->foreign('id_detail_kriteria')->references('id_detail_kriteria')->on('t_detail_kriteria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_data_pendukung');
    }
};
