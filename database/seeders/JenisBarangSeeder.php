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

    }
}
