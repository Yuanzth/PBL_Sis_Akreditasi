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
        Schema::create('t_komentar', function (Blueprint $table) {
            $table->string('id_komentar', 10)->primary();
            $table->string('id_user', 10);
            $table->string('id_data_pendukung', 10);
            $table->text('komentar');
            $table->foreign('id_user')->references('id_user')->on('m_user')->onDelete('cascade');
            $table->foreign('id_data_pendukung')->references('id_data_pendukung')->on('t_data_pendukung')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_komentar');
    }
};
