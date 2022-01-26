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
            $table->datetime('batasan_waktu')->nullable();
            $table->enum('status', ['Belum lunas', 'Sudah lunas'])->default('Belum lunas');
            $table->datetime('waktu_lunas')->nullable();
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
