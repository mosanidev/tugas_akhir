<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('supplier');

        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 55);
            $table->string('alamat', 100);
            $table->string('nomor_telepon', 20);
            $table->enum('jenis', ['Perusahaan', 'Individu']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier');
    }
}
