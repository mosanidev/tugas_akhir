<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ReturPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('retur_pembelian')->delete();

        DB::table('retur_pembelian')->insert(
            [   
                'id'                        => 1,  
                'tanggal'                   => '2021-11-30',
                'total_barang_diretur'      => 100,
                'pembelian_id'              => 1
            ]
        );
    }
}
