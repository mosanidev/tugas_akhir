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
                'barang_id'                 => 11,
                'kuantitas'                 => 100,
                // 'harga_beli'                => 5000,
                'subtotal'                  => 500000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 1,  
                'barang_id'                 => 24,
                'kuantitas'                 => 900,
                // 'harga_beli'                => 7200,
                'subtotal'                  => 360000
            ]
        );
    }
}
