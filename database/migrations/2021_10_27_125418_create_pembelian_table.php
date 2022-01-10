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
            $table->unsignedInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->smallInteger('sistem_konsinyasi');
            $table->date('tanggal_jatuh_tempo');
            $table->double('diskon')->default(0);
            $table->double('ppn')->default(0);
            $table->enum('metode_pembayaran', ['Transfer Bank', 'Tunai']);
            $table->enum('status', ['Belum Lunas', 'Sudah Lunas']);
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
