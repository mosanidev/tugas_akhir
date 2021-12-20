<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiplePengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('multiple_pengiriman');

        Schema::create('multiple_pengiriman', function (Blueprint $table) {
            $table->unsignedInteger('pengiriman_id')->nullable();
            $table->foreign('pengiriman_id')->references('id')->on('pengiriman')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('alamat_pengiriman_id')->nullable();
            $table->foreign('alamat_pengiriman_id')->references('id')->on('alamat_pengiriman')->onUpdate('cascade')->onDelete('cascade');
            $table->double('total_tarif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multiple_pengiriman');
    }
}
