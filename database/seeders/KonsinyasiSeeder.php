<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class KonsinyasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('konsinyasi')->delete();
        
        DB::table('konsinyasi')->insert(
            [   
                'id'                    => 1,  
                'nomor_nota'            => 'NK0001',
                'supplier_id'           => 3,
                'tanggal_titip'         => '2022-02-06',
                'tanggal_jatuh_tempo'   => '2022-02-26',
                'metode_pembayaran'     => 'Tunai',
                'status'                => 'Belum Lunas',
                'bukti_bayar'           => null
            ]
        );
    }
}
