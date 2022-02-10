<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('back_order');

        Schema::create('back_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pemesanan_id');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');                 
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
        Schema::dropIfExists('back_order');
    }
}
