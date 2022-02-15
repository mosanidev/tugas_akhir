<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodeDiskonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('periode_diskon');

        Schema::create('periode_diskon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 55)->nullable();
            $table->date('tanggal_dimulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('keterangan', 500)->nullable();
            // $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periode_diskon');
    }
}
