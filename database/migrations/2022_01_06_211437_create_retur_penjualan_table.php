<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('retur_penjualan');

        Schema::create('retur_penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('penjualan_id');
            $table->foreign('penjualan_id')->references('id')->on('penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['Menunggu pengajuan dicek admin', 'Pengajuan retur ditolak', 'Pengajuan retur diterima dan sedang di proses', 'Barang retur dikirim ke alamat anda', 'Proses retur selesai']);
            $table->string('link', 500);
            $table->integer('total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_penjualan');
    }
}
