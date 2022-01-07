<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKonsinyasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_konsinyasi');

        Schema::create('detail_konsinyasi', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('konsinyasi_id');
            $table->foreign('konsinyasi_id')->references('id')->on('konsinyasi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade'); 
            $table->integer('jumlah_titip');
            $table->integer('terjual');
            $table->integer('sisa');
            $table->integer('total_hutang');
            $table->integer('total_komisi');
            $table->enum('status', ['Belum Lunas', 'Sudah Lunas']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_titipan_konsinyasi');
    }
}
