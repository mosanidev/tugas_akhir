<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningReturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rekening_retur');

        Schema::create('rekening_retur', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank');
            $table->string('nama_pemilik_rekening');
            $table->string('nomor_rekening');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening_retur');
    }
}
