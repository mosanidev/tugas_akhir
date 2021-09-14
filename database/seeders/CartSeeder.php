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
        
        DB::table('cart')->insert(
            [   
                'id'                        => 1,  
                'barang_id'                 => 1,
                'kuantitas'                 => 2,
                'subtotal'                  => 160000,
                'total'                     => 160000, 
                'users_id'                  => 1
            ]
        );

    }
}
