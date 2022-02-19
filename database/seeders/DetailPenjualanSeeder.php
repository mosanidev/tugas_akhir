<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_penjualan')->delete();
        
        DB::table('detail_penjualan')->insert([

            'penjualan_id'              => 1,
            'barang_id'                 => 8,
            'kuantitas'                 => 3,
            'subtotal'                  => 23700,
            'pengiriman_id'             => 1,
            'alamat_pengiriman_id'      => 1

        ]);

        DB::table('detail_penjualan')->insert([

            'penjualan_id'              => 1,
            'barang_id'                 => 19,
            'kuantitas'                 => 1,
            'subtotal'                  => 34400,
            'pengiriman_id'             => 1,
            'alamat_pengiriman_id'      => 1

        ]);

        DB::table('detail_penjualan')->insert([

            'penjualan_id'              => 2,
            'barang_id'                 => 22,
            'kuantitas'                 => 5,
            'subtotal'                  => 39500,
            'pengiriman_id'             => 2,
            'alamat_pengiriman_id'      => 1

        ]);

        DB::table('detail_penjualan')->insert([

            'penjualan_id'              => 2,
            'barang_id'                 => 24,
            'kuantitas'                 => 5,
            'subtotal'                  => 38500,
            'pengiriman_id'             => 2,
            'alamat_pengiriman_id'      => 1

        ]);

        DB::table('detail_penjualan')->insert([

            'penjualan_id'              => 2,
            'barang_id'                 => 18,
            'kuantitas'                 => 10,
            'subtotal'                  => 177000,
            'pengiriman_id'             => 2,
            'alamat_pengiriman_id'      => 1

        ]);
    }
}
