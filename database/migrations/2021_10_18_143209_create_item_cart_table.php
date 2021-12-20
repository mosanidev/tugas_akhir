<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('item_cart');

        // Schema::create('item_cart', function (Blueprint $table) {
        //     $table->unsignedInteger('cart_id');
        //     $table->foreign('cart_id')->on('cart')->references('id')->onUpdate('cascade')->onDelete('cascade');
        //     $table->unsignedInteger('barang_id');
        //     $table->foreign('barang_id')->on('barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
        //     $table->integer('kuantitas');
        //     $table->double('subtotal');
        //     $table->double('total');
        //     $table->unsignedInteger('pengiriman_id')->nullable();
        //     $table->foreign('pengiriman_id')->on('multiple_pengiriman')->references('pengiriman_id')->onUpdate('cascade')->onDelete('cascade');
        //     $table->unsignedInteger('alamat_pengiriman_id')->nullable();
        //     $table->foreign('alamat_pengiriman_id')->on('multiple_pengiriman')->references('alamat_pengiriman_id')->onUpdate('cascade')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_cart');
    }
}
