<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pembelian')->delete();
        
        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 1,  
                'barang_id'                 => 8,
                'tanggal_kadaluarsa'        => '2022-01-29 00:00:00',
                'kuantitas'                 => 2,
                'harga_beli'                => 5000,
                'subtotal'                  => 10000
            ]
        );

        // DB::table('detail_pembelian')->insert(
        //     [   
        //         'pembelian_id'              => 1,  
        //         'barang_id'                 => 24,
        //         'kuantitas'                 => 900,
        //         // 'harga_beli'                => 7200,
        //         'subtotal'                  => 360000
        //     ]
        // );
    }
}
