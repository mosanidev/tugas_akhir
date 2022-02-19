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
            $table->string('status');
            $table->enum('jenis', ['Pengembalian dana', 'Tukar barang']);
            $table->unsignedInteger('rekening_retur_id')->nullable();
            $table->foreign('rekening_retur_id')->references('id')->on('rekening_retur')->onUpdate('cascade')->onDelete('cascade');
            $table->string('link', 500);
            $table->string('foto_bukti_pengembalian_dana', 500)->nullable();
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
