<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailReturPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_retur_pembelian')->delete();

        DB::table('detail_retur_pembelian')->insert(
            [   
                'retur_pembelian_id'        => 1,  
                'barang_id'                 => 11,
                'keterangan'                => 'Rusak',
                'jumlah_retur'              => 50,
                'subtotal'                  => 250000, 
                'total'                     => 610000,
                'status'                    => 'Sudah diterima'
            ]
        );

        DB::table('detail_retur_pembelian')->insert(
            [   
                'retur_pembelian_id'        => 1,  
                'barang_id'                 => 11,
                'keterangan'                => 'Rusak',
                'jumlah_retur'              => 50,
                'subtotal'                  => 360000, 
                'total'                     => 610000,
                'status'                    => 'Sudah diterima'
            ]
        );
    }
}
