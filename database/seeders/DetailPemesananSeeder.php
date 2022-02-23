<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pemesanan')->delete();

        // DB::table('detail_pemesanan')->insert([
        //     'pemesanan_id' => 1,
        //     'barang_id' => 8,
        //     'harga_pesan' => 2400,
        //     'kuantitas' => 2,
        //     'subtotal' => 4800
        // ]);

        // DB::table('detail_pemesanan')->insert([
        //     'pemesanan_id' => 1,
        //     'barang_id' => 15,
        //     'harga_pesan' => 1900,
        //     'kuantitas' => 3,
        //     'subtotal' => 5700
        // ]);
    }
}
