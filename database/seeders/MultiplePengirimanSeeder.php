<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MultiplePengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('multiple_pengiriman')->delete();
        
        DB::table('multiple_pengiriman')->insert(
            [   
                'pengiriman_id'             => 1,  
                'alamat_pengiriman_id'      => 1,
                'total_tarif'               => 7000
            ]
        );

        DB::table('multiple_pengiriman')->insert(
            [   
                'pengiriman_id'             => 2,  
                'alamat_pengiriman_id'      => 1,
                'total_tarif'               => 14000
            ]
        );
    }
}
