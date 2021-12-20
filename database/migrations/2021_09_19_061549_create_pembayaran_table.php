<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pembayaran');

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('metode_pembayaran', 25);
            $table->string('bank', 10)->nullable();
            $table->string('nomor_rekening', 35)->nullable();
            // $table->string('link_qrcode', 255)->nullable();
            $table->datetime('batasan_waktu')->nullable();
            $table->datetime('waktu_lunas')->nullable();
            // $table->datetime('waktu_pembayaran')->nullable();
            // $table->enum('status', ['Sudah Dibayar', 'Menunggu Pembayaran', 'Pembayaran melewati batasan waktu', 'Error']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
