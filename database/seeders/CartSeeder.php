<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cart')->delete();
        
        

    }
}
