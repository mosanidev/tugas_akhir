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
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->string('keterangan', 1000);
            $table->integer('jumlah_retur');
            $table->integer('subtotal');
            $table->integer('total');
            $table->enum('status', ['Belum diterima', 'Sudah diterima'])->defaut('Sudah diterima');
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
