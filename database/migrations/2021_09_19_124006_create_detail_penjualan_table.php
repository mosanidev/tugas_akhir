<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_penjualan');

        Schema::create('detail_penjualan', function (Blueprint $table) {
            // $table->increments('id');
            $table->unsignedInteger('penjualan_id');
            $table->foreign('penjualan_id')->references('id')->on('penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            // $table->unsignedInteger('tanggal_kadaluarsa_id');
            // $table->foreign('tanggal_kadaluarsa_id')->references('tanggal_kadaluarsa_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas');
            $table->double('subtotal');
            // $table->double('total');
            $table->unsignedInteger('pengiriman_id')->nullable();
            $table->foreign('pengiriman_id')->references('pengiriman_id')->on('multiple_pengiriman')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('alamat_pengiriman_id')->nullable();
            $table->foreign('alamat_pengiriman_id')->references('alamat_pengiriman_id')->on('multiple_pengiriman')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('pengiriman_id')->references('id')->on('pengiriman')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('pengiriman_id')->nullable();
            // $table->foreign('pengiriman_id')->references('id')->on('pengiriman')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('cart_id');
            // $table->foreign('cart_id')->references('id')->on('cart')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
}
