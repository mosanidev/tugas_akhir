<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pembelian')->delete();
        
        
    }
}
