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
                'status'                       => 'Draft',
                'estimasi_tiba'                => '2022-02-07 00:00:00'
            ]
        );
    }
}
