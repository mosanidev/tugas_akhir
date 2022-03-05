<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengiriman')->delete();
        
        
    }
}
