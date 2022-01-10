<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cart');

        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('barang_id');
            $table->foreign('barang_id')->references('barang_id')->on('barang_has_kadaluarsa')->onUpdate('cascade')->onDelete('cascade'); 
            // $table->foreign('barang_id')->on('barang')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('kuantitas')->default(1);
            $table->double('subtotal');
            $table->double('total')->default(0);
            $table->unsignedInteger('pengiriman_id')->nullable();
            $table->foreign('pengiriman_id')->on('pengiriman')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('alamat_pengiriman_id')->nullable();
            $table->foreign('alamat_pengiriman_id')->on('alamat_pengiriman')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['barang_id','users_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
