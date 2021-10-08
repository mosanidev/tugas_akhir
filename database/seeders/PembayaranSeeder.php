<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pembayaran')->delete();
        
        DB::table('pembayaran')->insert(
            [   
                'id'                   => 1,  
                'metode_pembayaran'    => 'bank_transfer',
                'deadline'             => Carbon::now(),
                'status'               => 'pending'
            ]
        );
    }
}
