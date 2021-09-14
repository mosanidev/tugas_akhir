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
            $table->increments('id');
            $table->string('nama', 55);
            $table->string('email', 100);
            $table->string('password', 255);    
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nomor_telepon', 20);    
            $table->enum('jenis', ['Admin', 'Manajer', 'Anggota_Kopkar', 'Pelanggan']);
            $table->enum('status_verifikasi_anggota', ['Unverified', 'Verified']);
            $table->string('nomor_anggota', 100)->nullable(); 
            $table->date('tanggal_lahir');
            $table->string('foto', 255)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
