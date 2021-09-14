<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatPengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('alamat_pengiriman');

        Schema::create('alamat_pengiriman', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 55);
            $table->string('nama_penerima', 55);
            $table->string('nomor_telepon', 20);
            $table->string('alamat', 100);
            $table->smallInteger('alamat_utama')->default(0);
            $table->string('kecamatan', 100);
            $table->integer('kode_pos');
            $table->string('kota_kabupaten', 70);
            $table->string('provinsi', 70);
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alamat_pengiriman');
    }
}
