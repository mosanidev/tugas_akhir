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
                'kategori_barang'   => 'Makanan Bungkusan'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 2,  
                'kategori_barang'   => 'Cemilan'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 3,  
                'kategori_barang'   => 'Minuman Kemasan'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 4,  
                'kategori_barang'   => 'Kebersihan Tubuh'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 5,  
                'kategori_barang'   => 'Vitamin'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 6,  
                'kategori_barang'   => 'Obat'
            ]
        );
    }
}
