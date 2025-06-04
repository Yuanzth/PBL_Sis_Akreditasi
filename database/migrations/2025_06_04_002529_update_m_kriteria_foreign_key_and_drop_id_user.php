<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('m_kriteria', function (Blueprint $table) {
            // Tambahkan foreign key constraint untuk id_level
            $table->foreign('id_level')->references('id_level')->on('m_level')->onDelete('restrict')->onUpdate('cascade');

            // Hapus kolom id_user dan foreign key-nya
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
    }

    public function down()
    {
        Schema::table('m_kriteria', function (Blueprint $table) {
            // Tambahkan kembali kolom id_user
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('m_user')->onDelete('restrict')->onUpdate('cascade');

            // Hapus foreign key id_level
            $table->dropForeign(['id_level']);
            $table->dropColumn('id_level');
        });
    }
};