<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenerimaanPemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_penerimaan_pemesanan');

        // Schema::create('detail_penerimaan_pemesanan', function (Blueprint $table) {
        //     $table->unsignedInteger('pemesanan_id');
        //     $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onUpdate('cascade')->onDelete('cascade');
        //     $table->unsignedInteger('barang_id');
        //     $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
        //     $table->datetime('tanggal_kadaluarsa'); 
        //     $table->double('harga_pesan');
        //     $table->double('diskon_potongan_harga');
        //     $table->integer('jumlah_pesan');
        //     $table->integer('jumlah_terima');
        //     $table->double('subtotal');
        // });

        Schema::create('detail_penerimaan_pemesanan', function (Blueprint $table) {
            $table->unsignedInteger('pemesanan_id');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            // $table->datetime('tanggal_kadaluarsa'); 
            // $table->double('harga_pesan');
            // $table->double('diskon_potongan_harga');
            $table->integer('jumlah_pesan');
            $table->integer('jumlah_terima');
            $table->integer('jumlah_tidak_terima');
            // $table->double('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penerimaan_pemesanan');
    }
}
