<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_penjualan')->delete();
        
        
    }
}
