<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penjualan')->delete();
        
        
    }
}
