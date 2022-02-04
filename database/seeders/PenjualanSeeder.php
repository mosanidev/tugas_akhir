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
                'pembayaran_id'             => 2,
                'metode_transaksi'          => 'Dikirim ke alamat',
                'status_jual'               => 'Pesanan sudah dibayar',
                'jenis'                     => 'Online',
                'total'                     => 65100,
                'created_at'                => '2022-02-04 16:12:42',
                'updated_at'                => '2022-02-04 16:13:09'
            ]
        );
    }
}
