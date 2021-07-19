<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('email');
            $table->string('password');
            $table->string('nomor_telepon');
            $table->string('jenis');
            $table->string('status_verifikasi_anggota');
            $table->unsignedBigInteger('id_anggota_koperasi')->nullable();
            $table->foreign('id_anggota_koperasi')->references('id')->on('anggota_koperasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
