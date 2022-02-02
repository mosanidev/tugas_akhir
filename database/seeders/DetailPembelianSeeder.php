<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DetailPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_pembelian')->delete();
        
        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 1,  
                'barang_id'                 => 8,
                'tanggal_kadaluarsa'        => '2022-01-29 00:00:00',
                'kuantitas'                 => 2,
                'harga_beli'                => 5000,
                'subtotal'                  => 10000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 8,
                'tanggal_kadaluarsa'        => '2023-07-08 00:00:00',
                'kuantitas'                 => 30,
                'harga_beli'                => 3500,
                'subtotal'                  => 105000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 10,
                'tanggal_kadaluarsa'        => '2023-05-03 00:00:00',
                'kuantitas'                 => 35,
                'harga_beli'                => 3200,
                'subtotal'                  => 112000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 11,
                'tanggal_kadaluarsa'        => '2023-10-13 00:00:00',
                'kuantitas'                 => 40,
                'harga_beli'                => 2000,
                'subtotal'                  => 80000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 13,
                'tanggal_kadaluarsa'        => '2023-09-04 00:00:00',
                'kuantitas'                 => 50,
                'harga_beli'                => 3000,
                'subtotal'                  => 150000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 14,
                'tanggal_kadaluarsa'        => '2023-02-08 00:00:00',
                'kuantitas'                 => 60,
                'harga_beli'                => 2300,
                'subtotal'                  => 138000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 15,
                'tanggal_kadaluarsa'        => '2023-01-15 00:00:00',
                'kuantitas'                 => 45,
                'harga_beli'                => 3100,
                'subtotal'                  => 139500
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 16,
                'tanggal_kadaluarsa'        => '2023-09-16 00:00:00',
                'kuantitas'                 => 33,
                'harga_beli'                => 3400,
                'subtotal'                  => 112200
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 17,
                'tanggal_kadaluarsa'        => '2023-09-04 00:00:00',
                'kuantitas'                 => 30,
                'harga_beli'                => 3200,
                'subtotal'                  => 96000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 18,
                'tanggal_kadaluarsa'        => '2022-08-05 00:00:00',
                'kuantitas'                 => 30,
                'harga_beli'                => 6000,
                'subtotal'                  => 180000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 19,
                'tanggal_kadaluarsa'        => '2022-12-06 00:00:00',
                'kuantitas'                 => 34,
                'harga_beli'                => 6800,
                'subtotal'                  => 231200
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 20,
                'tanggal_kadaluarsa'        => '2022-11-30 00:00:00',
                'kuantitas'                 => 20,
                'harga_beli'                => 2700,
                'subtotal'                  => 54000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 22,
                'tanggal_kadaluarsa'        => '2022-11-19 00:00:00',
                'kuantitas'                 => 22,
                'harga_beli'                => 3200,
                'subtotal'                  => 70400
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 23,
                'tanggal_kadaluarsa'        => '2022-11-17 00:00:00',
                'kuantitas'                 => 50,
                'harga_beli'                => 6100,
                'subtotal'                  => 305000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 24,
                'tanggal_kadaluarsa'        => '2022-11-26 00:00:00',
                'kuantitas'                 => 34,
                'harga_beli'                => 7300,
                'subtotal'                  => 248200
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 25,
                'tanggal_kadaluarsa'        => '2022-11-27 00:00:00',
                'kuantitas'                 => 30,
                'harga_beli'                => 4000,
                'subtotal'                  => 120000
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 26,
                'tanggal_kadaluarsa'        => '2022-11-17 00:00:00',
                'kuantitas'                 => 12,
                'harga_beli'                => 1100,
                'subtotal'                  => 13200
            ]
        );

        DB::table('detail_pembelian')->insert(
            [   
                'pembelian_id'              => 2,  
                'barang_id'                 => 29,
                'tanggal_kadaluarsa'        => '2022-10-26 00:00:00',
                'kuantitas'                 => 18,
                'harga_beli'                => 3400,
                'subtotal'                  => 61200
            ]
        );
    }
}
