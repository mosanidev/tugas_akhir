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
            // $table->double('harga_beli');
            $table->double('diskon_potongan_harga')->default(0);
            $table->double('perkiraan_harga_beli')->default(0);
            // $table->integer('jumlah_stok')->default(0);
            // $table->datetime('tanggal_kadaluarsa');
            // $table->time('jam_kadaluarsa')->default('23:59:59');
            $table->double('berat');
            $table->enum('satuan', ['PCS', 'DUS', 'PAK'])->default('PCS');
            $table->string('foto', 200)->default("/images/barang/barang_null.png");
            $table->unsignedInteger('jenis_id');
            $table->foreign('jenis_id')->on('jenis_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('kategori_id');
            $table->foreign('kategori_id')->on('kategori_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('merek_id');
            $table->foreign('merek_id')->on('merek_barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('batasan_stok_minimum')->default(3);
            // $table->double('komisi')->default(0);
            // $table->smallInteger('opsi_otomatis_update_kadaluarsa')->default(0);
            $table->smallInteger('barang_konsinyasi')->default(0);
            $table->unsignedInteger('periode_diskon_id')->nullable();
            $table->foreign('periode_diskon_id')->on('periode_diskon')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
