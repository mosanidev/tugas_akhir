<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHasKadaluarsa2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('barang_has_kadaluarsa_2');

        Schema::create('barang_has_kadaluarsa_2', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('tanggal_kadaluarsa');
            $table->unsignedInteger('jumlah_stok_di_gudang');
            $table->unsignedInteger('jumlah_stok_di_rak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_has_kadaluarsa_2');
    }
}
