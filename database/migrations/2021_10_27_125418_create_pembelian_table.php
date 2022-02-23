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
            $table->string('nomor_nota_dari_supplier', 100)->nullable();
            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');
            $table->unsignedInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal_jatuh_tempo');
            $table->double('diskon')->default(0);
            $table->double('ppn')->default(0);
            $table->enum('metode_pembayaran', ['Transfer bank', 'Tunai']);
            $table->enum('status_bayar', ['Belum lunas', 'Sudah lunas', 'Lunas sebagian']);
            $table->enum('status_retur', ['Tidak ada retur', 'Ada retur'])->default('Tidak ada retur');
            $table->double('total');
            $table->double('uang_muka')->default(0);
            $table->double('ongkos_kirim')->default(0);
            $table->double('total_terbayar')->default(0);
            $table->double('sisa_belum_bayar')->default(0);

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
