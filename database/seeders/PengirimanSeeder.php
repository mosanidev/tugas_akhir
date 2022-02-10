<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengiriman')->delete();
        
        DB::table('pengiriman')->insert(
            [   
                'id'                           => 1,  
                'tarif'                        => 7000,
                'kode_shipper'                 => 'jne',
                'kode_jenis_pengiriman'        => 'reg',
                'jenis_pengiriman'             => 'Reguler',
                'total_berat'                  => 260,
                'status_pengiriman'            => 'Pesanan sedang disiapkan untuk diserahkan ke pengirim',
                'estimasi_tiba'                => '2022-02-07 00:00:00'
            ]
        );

        DB::table('pengiriman')->insert(
            [   
                'id'                           => 2,  
                'tarif'                        => 14000,
                'kode_shipper'                 => 'jne',
                'kode_jenis_pengiriman'        => 'reg',
                'jenis_pengiriman'             => 'Reguler',
                'total_berat'                  => 1325,
                'status_pengiriman'            => 'Pesanan sudah sampai',
                'estimasi_tiba'                => '2022-02-14 00:00:00'
            ]
        );
    }
}
