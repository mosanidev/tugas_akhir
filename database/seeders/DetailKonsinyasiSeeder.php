<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailKonsinyasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_konsinyasi')->delete();
        
        // DB::table('detail_konsinyasi')->insert(
        //     [   
        //         'konsinyasi_id'         => 1,  
        //         'barang_id'             => 1,
        //         'tanggal_kadaluarsa'    => '2022-02-26 16:00:00',
        //         'jumlah_titip'          => 9,
        //         'komisi'                => 3000,
        //         'hutang'                => 9000,
        //         'subtotal_komisi'       => 27000,
        //         'subtotal_hutang'       => 81000
        //     ]
        // );

        // DB::table('detail_konsinyasi')->insert(
        //     [   
        //         'konsinyasi_id'         => 1,  
        //         'barang_id'             => 2,
        //         'tanggal_kadaluarsa'    => '2022-02-26 16:00:00',
        //         'jumlah_titip'          => 8,
        //         'komisi'                => 3000,
        //         'hutang'                => 10000,
        //         'subtotal_komisi'       => 24000,
        //         'subtotal_hutang'       => 80000
        //     ]
        // );
    }
}
