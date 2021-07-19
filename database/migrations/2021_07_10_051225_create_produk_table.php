<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('produk');

        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi');
            $table->double('harga');
            $table->double('diskon_potongan_harga');
            $table->string('satuan');
            $table->integer('stok');
            $table->date('tanggal_kadaluarsa');
            $table->integer('berat');
            $table->string('gambar');
            $table->unsignedBigInteger('id_jenis_produk');
            $table->foreign('id_jenis_produk')->references('id')->on('jenis_produk');
            $table->unsignedBigInteger('id_kategori_produk');
            $table->foreign('id_kategori_produk')->references('id')->on('kategori_produk');
            $table->unsignedBigInteger('id_merek_produk');
            $table->foreign('id_merek_produk')->references('id')->on('merek_produk');
            $table->unsignedBigInteger('id_supplier');
            $table->foreign('id_supplier')->references('id')->on('supplier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('produk');
    }
}
