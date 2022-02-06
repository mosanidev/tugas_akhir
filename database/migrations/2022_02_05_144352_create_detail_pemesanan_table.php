<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_pemesanan');

        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->unsignedInteger('pemesanan_id');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade'); 
            $table->datetime('harga_beli');
            $table->integer('kuantitas');
            $table->double('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pemesanan');
    }
}
