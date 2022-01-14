<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReturPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_retur_pembelian');

        Schema::create('detail_retur_pembelian', function (Blueprint $table) {
            $table->unsignedInteger('retur_pembelian_id');
            $table->foreign('retur_pembelian_id')->references('id')->on('retur_pembelian')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_retur');
            $table->unsignedInteger('barang_ganti')->nullable();
            $table->foreign('barang_retur')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreign('barang_ganti')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            $table->datetime('tanggal_kadaluarsa_barang_retur');       
            $table->datetime('tanggal_kadaluarsa_barang_ganti')->nullable();     
            $table->string('keterangan', 1000);
            $table->integer('kuantitas_barang_retur');
            $table->integer('kuantitas_barang_ganti')->nullable();
            $table->double('subtotal')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_retur_pembelian');
    }
}
