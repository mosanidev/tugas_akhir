<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsinyasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('konsinyasi');

        Schema::create('konsinyasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_nota', 100);
            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal_titip');
            $table->date('tanggal_jatuh_tempo');
            $table->double('total_komisi');
            $table->double('total_hutang');
            $table->enum('metode_pembayaran', ['Transfer Bank', 'Tunai']);
            $table->enum('status_bayar', ['Belum Lunas', 'Sudah Lunas']);
            $table->string('bukti_bayar', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsinyasi');
    }
}
