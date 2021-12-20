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
                'merek_barang'         => 'Nu'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 3,  
                'merek_barang'         => 'Wings Food'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 4,  
                'merek_barang'         => 'Komix'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 5,  
                'merek_barang'         => 'Beng-Beng'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 6,  
                'merek_barang'         => 'Roma'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 7,  
                'merek_barang'         => 'Oreo'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 8,  
                'merek_barang'         => 'Promag'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 9,  
                'merek_barang'         => 'Floridina'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 10,  
                'merek_barang'         => 'Javana'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 11,  
                'merek_barang'         => 'Oskadon'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 12,  
                'merek_barang'         => 'Pepsodent'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 13,  
                'merek_barang'         => 'Baygon'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 14,  
                'merek_barang'         => 'Paseo'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 15,  
                'merek_barang'         => 'Molto'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 16,  
                'merek_barang'         => 'Close Up'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 17,  
                'merek_barang'         => 'Wings'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 18,  
                'merek_barang'         => 'Shinzui'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 19,  
                'merek_barang'         => 'Rapika'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 20,  
                'merek_barang'         => 'Sunsilk'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 21,  
                'merek_barang'         => 'Lifebuoy'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 22,  
                'merek_barang'         => 'Nuvo'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 23,  
                'merek_barang'         => 'Snowman'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 24,  
                'merek_barang'         => 'Linco'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 25,  
                'merek_barang'         => 'Sariwangi'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 26,  
                'merek_barang'         => 'Zhonghua'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 27,  
                'merek_barang'         => 'Faster'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 28,  
                'merek_barang'         => 'Standard'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 29,  
                'merek_barang'         => 'Gilette'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 30,  
                'merek_barang'         => 'Joyco'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 31,  
                'merek_barang'         => 'Povinal'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 32,  
                'merek_barang'         => 'Hansaplant'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 33,  
                'merek_barang'         => 'Safecare'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 34,  
                'merek_barang'         => 'Povinal'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 35,  
                'merek_barang'         => "Pond's"
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 36,  
                'merek_barang'         => 'Biore'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 37,  
                'merek_barang'         => 'Fisherman'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 38,  
                'merek_barang'         => 'Eveready'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 39,  
                'merek_barang'         => 'ABC'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 40,  
                'merek_barang'         => 'Gofress'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 41,  
                'merek_barang'         => 'Tolakangin'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 42,  
                'merek_barang'         => 'Mentos'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 43,  
                'merek_barang'         => 'Yupi'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 44,  
                'merek_barang'         => 'Frozz'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 45,  
                'merek_barang'         => 'Chitato'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 46,  
                'merek_barang'         => 'Cheetos'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 47,  
                'merek_barang'         => 'Smax Snack'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 48,  
                'merek_barang'         => 'Kopiko'
            ]
        );

        DB::table('merek_barang')->insert(
            [   
                'id'                   => 49,  
                'merek_barang'         => 'Ultrajaya'
            ]
        );
    }
}
