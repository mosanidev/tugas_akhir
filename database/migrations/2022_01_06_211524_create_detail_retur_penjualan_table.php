<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_retur_penjualan');

        Schema::create('detail_retur_penjualan', function (Blueprint $table) {
            $table->unsignedInteger('retur_penjualan_id');
            $table->foreign('retur_penjualan_id')->references('id')->on('retur_penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_retur');
            $table->foreign('barang_retur')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas_barang_retur');
            $table->unsignedInteger('barang_ganti')->nullable();
            $table->foreign('barang_ganti')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas_barang_ganti')->nullable();
            $table->integer('subtotal')->nullable();
            $table->string('alasan_retur', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_retur_penjualan');
    }
}
