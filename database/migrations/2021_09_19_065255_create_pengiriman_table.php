<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pengiriman');

        Schema::create('pengiriman', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_resi', 100)->nullable();
            $table->double('tarif');
            $table->enum('status', ['-', 'proses_packing', 'diserahkan_pada_pihak_pengirim']);
            $table->string('kode_shipper');
            $table->foreign('kode_shipper')->references('kode_shipper')->on('shipper')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jenis_pengiriman', 55);
            $table->integer('total_berat');
            $table->unsignedInteger('alamat_pengiriman_id');
            $table->foreign('alamat_pengiriman_id')->references('id')->on('alamat_pengiriman')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
}
