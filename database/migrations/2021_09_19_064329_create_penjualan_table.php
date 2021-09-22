<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('penjualan');

        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('nomor_nota', 100)->primary();
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('tanggal');
            $table->unsignedInteger('pembayaran_id');
            $table->foreign('pembayaran_id')->references('id')->on('pembayaran')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('metode_transaksi', ['dikirim', 'ambil_di_toko']);
            $table->double('diskon_potongan_barang')->default(0);
            $table->double('poin_member_kopkar')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
