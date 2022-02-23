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
        
        DB::table('penjualan')->insert(
            [   
                'id'                        => 1,  
                'nomor_nota'                => '4BB72EFD5FED53E625E584',
                'users_id'                  => 1,
                'tanggal'                   => '2022-02-04 16:12:39',
                'pembayaran_id'             => 1,
                'metode_transaksi'          => 'Dikirim ke alamat',
                'status_jual'               => 'Pesanan sudah dibayar',
                'jenis'                     => 'Online',
                'total'                     => 65100
            ]
        );

        DB::table('penjualan')->insert(
            [   
                'id'                        => 2,  
                'nomor_nota'                => 'AD356FEF053248FC725463',
                'users_id'                  => 1,
                'tanggal'                   => '2022-02-11 00:20:37',
                'pembayaran_id'             => 2,
                'metode_transaksi'          => 'Dikirim ke alamat',
                'status_jual'               => 'Pesanan sudah selesai',
                'jenis'                     => 'Online',
                'total'                     => 269000
            ]
        );
    }
}
