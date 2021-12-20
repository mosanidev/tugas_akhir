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
                // 'sistem_konsinyasi'         => 1,
                'total'                     => 6980000
            ]
        );

    }
}
