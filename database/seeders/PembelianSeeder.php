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
                'id'                            => 1,  
                'nomor_nota_dari_supplier'      => 'NB0001',
                'supplier_id'                   => 1,
                'tanggal'                       => '2022-02-28',
                'tanggal_jatuh_tempo'           => '2022-02-28',
                'diskon'                        => 0,
                'ppn'                           => 0,
                'metode_pembayaran'             => 'Transfer bank',
                'status_bayar'                  => 'Belum lunas',
                'total'                         => 10000
            ]
        );
        

    }
}
