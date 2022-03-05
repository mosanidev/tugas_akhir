<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PeriodeDiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periode_diskon')->delete();

        DB::table('periode_diskon')->insert(
            [   
                'id'                        => 1,  
                'tanggal_dimulai'           => '2022-03-05',
                'tanggal_berakhir'          => '2022-03-31',
                'keterangan'                => 'Diskon untuk 3 barang'
            ]
        );

    }
}
