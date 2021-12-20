<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_barang')->delete();
        
        DB::table('jenis_barang')->insert(
            [   
                'id'           => 1,  
                'jenis_barang' => 'Makanan'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 2,  
                'jenis_barang' => 'Minuman'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 3,  
                'jenis_barang' => 'Kebersihan'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 4,  
                'jenis_barang' => 'Kesehatan'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 5,  
                'jenis_barang' => 'Perawatan'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 6,  
                'jenis_barang' => 'Rumah Tangga'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 7,  
                'jenis_barang' => 'Perlengkapan Kantor'
            ]
        );

        DB::table('jenis_barang')->insert(
            [   
                'id'           => 8,  
                'jenis_barang' => 'Perlengkapan Dapur'
            ]
        );
    }
}
