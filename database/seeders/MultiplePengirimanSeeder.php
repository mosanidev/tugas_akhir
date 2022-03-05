<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MultiplePengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('multiple_pengiriman')->delete();
        
        
    }
}
