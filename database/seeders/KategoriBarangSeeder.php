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
                'kategori_barang'   => 'Kebersihan Tubuh'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 8,  
                'kategori_barang'   => 'Kebersihan Pakaian'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 9,  
                'kategori_barang'   => 'Kebersihan Kamar Mandi'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 10,  
                'kategori_barang'   => 'Vitamin'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 11,  
                'kategori_barang'   => 'Obat Minum'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 12,  
                'kategori_barang'   => 'Obat Luar'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 13,  
                'kategori_barang'   => 'Minyak Gosok'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 14,  
                'kategori_barang'   => 'Obat Tablet'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 15,  
                'kategori_barang'   => 'Pembasmi Serangga'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 16,  
                'kategori_barang'   => 'Perawatan Pria'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 17,  
                'kategori_barang'   => 'Perawatan Wanita'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 18,  
                'kategori_barang'   => 'Alat Tulis'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 19,  
                'kategori_barang'   => 'Perlengkapan Kantor'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 20,  
                'kategori_barang'   => 'Bumbu Masakan'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 21,  
                'kategori_barang'   => 'Perlengkapan Dapur'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 22,  
                'kategori_barang'   => 'Makanan Kaleng'
            ]
        );

        DB::table('kategori_barang')->insert(
            [   
                'id'                => 23,  
                'kategori_barang'   => 'Gorengan'
            ]
        );

    }
}
