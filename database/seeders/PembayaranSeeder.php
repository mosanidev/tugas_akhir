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
                'metode_pembayaran'    => 'Transfer Bank',
                'batasan_waktu'        => Carbon::now()
            ]
        );

        DB::table('pembayaran')->insert(
            [   
                'id'                   => 2,  
                'metode_pembayaran'    => 'bank_transfer',
                'bank'                 => 'bca',
                'nomor_rekening'       => '41772366248',
                'batasan_waktu'        => '2022-02-04 19:12:39',
                'status_bayar'         => 'Sudah lunas',
                'waktu_lunas'          => '2022-02-04 16:13:07'
            ]
        );
    }
}
