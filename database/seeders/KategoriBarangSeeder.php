<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_barang')->delete();
        
        DB::table('kategori_barang')->insert(
            [   
                'id'                => 1,  
                'kategori_barang'   => 'Nasi Bungkus'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 2,  
                'kategori_barang'   => 'Makanan Ringan'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 3,  
                'kategori_barang'   => 'Cokelat & Permen'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 4,  
                'kategori_barang'   => 'Teh'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 5,  
                'kategori_barang'   => 'Kopi'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 6,  
                'kategori_barang'   => 'Air'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 7,  
                'kategori_barang'   => 'Minuman Isotonik'
            ]
        );

    }
}
