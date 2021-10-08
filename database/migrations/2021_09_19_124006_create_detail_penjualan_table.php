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
            $table->string('nomor_nota', 100);
            $table->foreign('nomor_nota')->references('nomor_nota')->on('penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas');
            $table->double('subtotal');
            $table->double('total');
            $table->unsignedInteger('pengiriman_id')->nullable();
            $table->foreign('pengiriman_id')->references('id')->on('pengiriman')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('alamat_pengiriman_id')->nullable();
            $table->foreign('alamat_pengiriman_id')->references('id')->on('alamat_pengiriman')->onUpdate('cascade')->onDelete('cascade');
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
