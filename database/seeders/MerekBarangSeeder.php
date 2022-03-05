<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MerekBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merek_barang')->delete();
        
        DB::table('merek_barang')->insert(
            [   
                'id'                   => 1,  
                'merek_barang'         => 'Kopkar UBAYA'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 2,  
                'merek_barang'         => 'Golda Coffee'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 3,  
                'merek_barang'         => 'YOU C1000'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 4,  
                'merek_barang'         => 'Good Day'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 5,  
                'merek_barang'         => 'Pocari Sweat'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 6,  
                'merek_barang'         => 'Teh Pucuk Harum'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 7,  
                'merek_barang'         => 'Gangsar'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 8,  
                'merek_barang'         => 'Japota'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 9,  
                'merek_barang'         => 'Potabee'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 10,  
                'merek_barang'         => 'Soyjoy'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 11,  
                'merek_barang'         => 'Nabati Siip'
            ]
        );
    }
}
