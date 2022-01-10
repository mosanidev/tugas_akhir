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
            $table->unsignedInteger('barang_asal');
            $table->unsignedInteger('barang_ganti');
            $table->foreign('barang_asal')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreign('barang_ganti')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            $table->datetime('tanggal_kadaluarsa_asal');     
            // $table->unsignedInteger('tanggal_kadaluarsa_asal');
            // $table->foreign('tanggal_kadaluarsa_asal')->references('tanggal_kadaluarsa_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade');      
            $table->datetime('tanggal_kadaluarsa_ganti');     
            $table->string('keterangan', 1000);
            $table->integer('kuantitas_barang_asal');
            $table->integer('kuantitas_barang_ganti');
            // $table->enum('status', ['Belum diterima', 'Sudah diterima'])->defaut('Sudah diterima');
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
