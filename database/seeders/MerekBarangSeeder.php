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
                'merek_barang'         => 'Chitato'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 2,  
                'merek_barang'         => 'Cheetos'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 3,  
                'merek_barang'         => 'Kopkar UBAYA'
            ]
        );

        $randchar = 'abcdefghijklmnopqrstuvwxyz';
    
        for ($i=4; $i<10; $i++)
        {
            DB::table('merek_barang')->insert(
                [   
                    'id'                   => $i,  
                    'merek_barang'         => str_shuffle($randchar)
                ]
            );
        }

        for ($i=10; $i<16; $i++)
        {
            DB::table('merek_barang')->insert(
                [   
                    'id'                   => $i,  
                    'merek_barang'         => str_shuffle($randchar)
                ]
            );
        }

        for ($i=16; $i<22; $i++)
        {
            DB::table('merek_barang')->insert(
                [   
                    'id'                   => $i,  
                    'merek_barang'         => str_shuffle($randchar)
                ]
            );
        }

        for ($i=22; $i<30; $i++)
        {
            DB::table('merek_barang')->insert(
                [   
                    'id'                   => $i,  
                    'merek_barang'         => str_shuffle($randchar)
                ]
            );
        }
    }
}
