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
                'ongkos_kirim'                  => 0,
                'total_terbayar'                => 0,
                'uang_muka'                     => 0,
                'metode_pembayaran'             => 'Transfer bank',
                'status_bayar'                  => 'Belum lunas',
                'total'                         => 10000,
                'sisa_belum_bayar'               => 10000,
                'total_terbayar'                => 0
            ]
        );

        // DB::table('pembelian')->insert(
        //     [   
        //         'id'                        => 2,  
        //         'nomor_nota'                => 'NB0002',
        //         'supplier_id'               => 1,
        //         'tanggal'                   => '2022-02-02',
        //         'tanggal_jatuh_tempo'       => '2022-02-16',
        //         'diskon'                    => 0,
        //         'ppn'                       => '0',
        //         'metode_pembayaran'         => 'Tunai',
        //         'status_bayar'              => 'Belum lunas',
        //         'total'                     => 2215900
        //     ]
        // );
        

    }
}
