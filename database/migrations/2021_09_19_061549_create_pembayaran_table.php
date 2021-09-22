<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pembayaran');

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('metode_pembayaran', 25);
            $table->datetime('waktu')->nullable();
            $table->enum('status', ['success', 'pending', 'expire', 'failed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
