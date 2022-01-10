<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailStokOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('detail_stok_opname');

        Schema::create('detail_stok_opname', function (Blueprint $table) {
            $table->unsignedInteger('stok_opname_id');
            $table->foreign('stok_opname_id')->references('id')->on('stok_opname')->onUpdate('cascade')->onDelete('cascade'); 
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            // $table->unsignedInteger('tanggal_kadaluarsa_id');
            // $table->foreign('tanggal_kadaluarsa_id')->references('tanggal_kadaluarsa_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah_selisih');
            $table->string('alasan', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_stok_opname');
    }
}
