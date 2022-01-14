<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('retur_pembelian');

        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->string('nomor_nota', 100)->unique();
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('pembelian_id');
            $table->foreign('pembelian_id')->references('id')->on('pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('kebijakan_retur', ['Tukar Barang', 'Potong Dana Pembelian', 'Pengembalian Dana Pembelian']);
            $table->integer('total')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_pembelian');
    }
}
