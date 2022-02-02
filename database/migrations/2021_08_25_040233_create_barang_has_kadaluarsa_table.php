<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangHasKadaluarsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('barang_has_kadaluarsa');

        Schema::create('barang_has_kadaluarsa', function (Blueprint $table) {
            // $table->increments('id');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('tanggal_kadaluarsa');
            // $table->unsignedInteger('tanggal_kadaluarsa_id');
            // $table->foreign('tanggal_kadaluarsa_id')->references('id')->on('tanggal_kadaluarsa')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('jumlah_stok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_has_kadaluarsa');
    }
}
