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
            $table->increments('id');
            $table->string('nomor_nota', 100)->unique();
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('tanggal');
            $table->unsignedInteger('pembayaran_id');
            $table->foreign('pembayaran_id')->references('id')->on('pembayaran')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('metode_transaksi', ['Dikirim ke alamat', 'Ambil di toko', 'Dikirim ke berbagai alamat']);
            $table->string('status')->nullable();
            // $table->date('batasan_waktu_pengambilan')->nullable();
            $table->double('total')->nullable();
            $table->timestamps();
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
