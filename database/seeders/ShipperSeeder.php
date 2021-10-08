<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipper')->delete();
        
        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'jne',  
                'nama'                 => 'JNE'
            ]
        );

        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'gojek',  
                'nama'                 => 'Gojek'
            ]
        );

        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'jnt',  
                'nama'                 => 'J&T'
            ]
        );

        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'sicepat',  
                'nama'                 => 'SiCepat'
            ]
        );

        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'grab',  
                'nama'                 => 'Grab'
            ]
        );

        DB::table('shipper')->insert(
            [   
                'kode_shipper'         => 'paxel',  
                'nama'                 => 'Paxel'
            ]
        );
    }
}
