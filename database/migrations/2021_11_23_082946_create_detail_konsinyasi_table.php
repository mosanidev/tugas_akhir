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
            $table->unsignedInteger('konsinyasi_id');
            $table->foreign('konsinyasi_id')->references('id')->on('konsinyasi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            // $table->unsignedInteger('tanggal_kadaluarsa_id');
            // $table->foreign('tanggal_kadaluarsa_id')->references('tanggal_kadaluarsa_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            $table->integer('jumlah_titip');
            $table->double('komisi');
            $table->double('hutang');
            $table->double('subtotal_komisi');
            $table->double('subtotal_hutang');
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
