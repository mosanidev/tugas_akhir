<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notifikasi');

        Schema::create('notifikasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isi', 500);
            $table->unsignedInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('penjualan_id');
            $table->foreign('penjualan_id')->references('id')->on('penjualan')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['Belum dilihat', 'Sudah dilihat']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}
