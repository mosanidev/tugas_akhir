<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BarangHasKadaluarsaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barang_has_kadaluarsa')->delete();
        
        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 8,  
            'tanggal_kadaluarsa'        => '2022-01-29 00:00:00',
            'jumlah_stok'               => 3
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 8,  
            'tanggal_kadaluarsa'        => '2022-02-25 00:00:00',
            'jumlah_stok'               => 5
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 1,  
            'tanggal_kadaluarsa'        => '2022-01-26 16:00:00',
            'jumlah_stok'               => 9
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 2,  
            'tanggal_kadaluarsa'        => '2022-01-26 16:00:00',
            'jumlah_stok'               => 8
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 8,  
            'tanggal_kadaluarsa'        => '2023-07-08 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 10,  
            'tanggal_kadaluarsa'        => '2023-05-03 00:00:00',
            'jumlah_stok'               => 35
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 11,  
            'tanggal_kadaluarsa'        => '2023-10-13 00:00:00',
            'jumlah_stok'               => 40
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 13,  
            'tanggal_kadaluarsa'        => '2023-09-04 00:00:00',
            'jumlah_stok'               => 50
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 14,  
            'tanggal_kadaluarsa'        => '2023-02-08 00:00:00',
            'jumlah_stok'               => 60
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 15,  
            'tanggal_kadaluarsa'        => '2023-01-15 00:00:00',
            'jumlah_stok'               => 45
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 16,  
            'tanggal_kadaluarsa'        => '2023-09-16 00:00:00',
            'jumlah_stok'               => 33
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 17,  
            'tanggal_kadaluarsa'        => '2023-09-04 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 18,  
            'tanggal_kadaluarsa'        => '2022-08-05 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 19,  
            'tanggal_kadaluarsa'        => '2022-12-06 00:00:00',
            'jumlah_stok'               => 34
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 20,  
            'tanggal_kadaluarsa'        => '2022-11-30 00:00:00',
            'jumlah_stok'               => 20
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 22,  
            'tanggal_kadaluarsa'        => '2022-11-19 00:00:00',
            'jumlah_stok'               => 22
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 23,  
            'tanggal_kadaluarsa'        => '2022-11-17 00:00:00',
            'jumlah_stok'               => 50
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 24,  
            'tanggal_kadaluarsa'        => '2022-11-26 00:00:00',
            'jumlah_stok'               => 34
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 25,  
            'tanggal_kadaluarsa'        => '2022-11-27 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 26,  
            'tanggal_kadaluarsa'        => '2022-11-17 00:00:00',
            'jumlah_stok'               => 12
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 29,  
            'tanggal_kadaluarsa'        => '2022-10-26 00:00:00',
            'jumlah_stok'               => 18
        ]);
    }

}
