<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transfer_barang');

        Schema::create('transfer_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->enum('lokasi_asal', ['Rak', 'Gudang']);
            $table->enum('lokasi_tujuan', ['Rak', 'Gudang']);
            $table->string('keterangan', 500)->nullable();
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_barang');
    }
}
