<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransferBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_transfer_barang');

        Schema::create('detail_transfer_barang', function (Blueprint $table) {
            $table->unsignedInteger('transfer_barang_id');
            $table->foreign('transfer_barang_id')->references('id')->on('transfer_barang')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('tanggal_kadaluarsa');
            $table->unsignedInteger('kuantitas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transfer_barang');
    }
}
