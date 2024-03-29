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
            // $table->string('nomor_nota', 100)->unique()->nullable();
            $table->string('nomor_nota', 100);
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('pembelian_id')->nullable();
            $table->foreign('pembelian_id')->references('id')->on('pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('konsinyasi_id')->nullable();
            $table->foreign('konsinyasi_id')->references('id')->on('konsinyasi')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kebijakan_retur', 100);
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
        Schema::dropIfExists('retur_pembelian');
    }
}
