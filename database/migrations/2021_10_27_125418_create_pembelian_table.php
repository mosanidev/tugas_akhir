<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pembelian');

        Schema::create('pembelian', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_nota', 100)->unique();
            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');
            // $table->smallInteger('sistem_konsinyasi');
            $table->date('tanggal_jatuh_tempo');
            $table->double('diskon')->default(0);
            $table->double('ppn')->default(0);
            $table->double('metode_pembayaran', ['Transfer Bank', 'Tunai']);
            $table->double('status', ['Belum Lunas', 'Sudah Lunas']);
            $table->double('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
