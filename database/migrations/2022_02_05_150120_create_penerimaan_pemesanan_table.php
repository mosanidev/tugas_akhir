<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanPemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('penerimaan_pemesanan');

        Schema::create('penerimaan_pemesanan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pemesanan_id');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');
            // $table->double('total')->nullable();
            $table->unsignedInteger('users_id'); 
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penerimaan_pemesanan');
    }
}
