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
            $table->string('id_pengiriman', 100)->nullable();
            $table->string('nomor_resi', 100)->nullable();
            $table->double('tarif');
            $table->string('kode_shipper');
            $table->foreign('kode_shipper')->references('kode_shipper')->on('shipper')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kode_jenis_pengiriman', 55);
            $table->string('jenis_pengiriman', 55);
            $table->integer('total_berat');
            $table->datetime('waktu_jemput')->nullable();
            // $table->string('catatan_untuk_kurir', 100)->nullable();
            // $table->string('status')->default('Draft');
            $table->string('status_pengiriman', 100);
            $table->datetime('estimasi_tiba');
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
