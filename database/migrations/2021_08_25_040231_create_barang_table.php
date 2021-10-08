<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('barang');

        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 55);
            $table->string('nama', 100);
            $table->string('deskripsi', 5000);
            $table->double('harga_jual');
            $table->double('diskon_potongan_harga');
            $table->enum('satuan', ['PCS', 'KG']);
            $table->integer('jumlah_stok');
            $table->date('tanggal_kadaluarsa');
            $table->integer('berat');
            $table->string('foto_1', 200)->nullable();
            $table->string('label', 100);
            $table->unsignedInteger('jenis_id');
            $table->foreign('jenis_id')->on('jenis_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('kategori_id');
            $table->foreign('kategori_id')->on('kategori_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('merek_id');
            $table->foreign('merek_id')->on('merek_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('batasan_stok_minimal');
            $table->integer('perkiraan_stok_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
