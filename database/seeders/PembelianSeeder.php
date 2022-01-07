<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembelian')->delete();
        
        DB::table('pembelian')->insert(
            [   
                'id'                        => 1,  
                'nomor_nota'                => 'PEMBELIAN001',
                'supplier_id'               => 3,
                'tanggal'                   => '2021-11-25',
                'tanggal_jatuh_tempo'       => '2021-12-09',
                'diskon'                    => 0,
                'ppn'                       => '0',
                'metode_pembayaran'         => 'Transfer Bank',
                'status'                    => 'Sudah Lunas',
                'total'                     => 0
            ]
        );

    }
}
