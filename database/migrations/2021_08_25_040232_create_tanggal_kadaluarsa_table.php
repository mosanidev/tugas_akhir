<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalKadaluarsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tanggal_kadaluarsa');

        // Schema::create('tanggal_kadaluarsa', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->datetime('tanggal_kadaluarsa');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanggal_kadaluarsa');
    }
}
