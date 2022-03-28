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
            'barang_id'                 => 1,  
            'tanggal_kadaluarsa'        => '2022-08-29 00:00:00',
            'jumlah_stok'               => 7
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 2,  
            'tanggal_kadaluarsa'        => '2022-12-25 00:00:00',
            'jumlah_stok'               => 5
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 3,  
            'tanggal_kadaluarsa'        => '2022-09-26 00:00:00',
            'jumlah_stok'               => 9
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 4,  
            'tanggal_kadaluarsa'        => '2022-04-10 00:00:00',
            'jumlah_stok'               => 8
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 5,  
            'tanggal_kadaluarsa'        => '2023-07-08 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 6,  
            'tanggal_kadaluarsa'        => '2023-05-03 00:00:00',
            'jumlah_stok'               => 35
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 7,  
            'tanggal_kadaluarsa'        => '2023-10-13 00:00:00',
            'jumlah_stok'               => 40
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 8,  
            'tanggal_kadaluarsa'        => '2023-09-04 00:00:00',
            'jumlah_stok'               => 50
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 9,  
            'tanggal_kadaluarsa'        => '2023-02-08 00:00:00',
            'jumlah_stok'               => 60
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 10,  
            'tanggal_kadaluarsa'        => '2023-01-15 00:00:00',
            'jumlah_stok'               => 45
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 11,  
            'tanggal_kadaluarsa'        => '2023-09-16 00:00:00',
            'jumlah_stok'               => 33
        ]);

        // DB::table('barang_has_kadaluarsa')->insert([
        //     'barang_id'                 => 12,  
        //     'tanggal_kadaluarsa'        => '2023-09-04 16:00:00',
        //     'jumlah_stok'               => 30
        // ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 13,  
            'tanggal_kadaluarsa'        => '2022-08-05 00:00:00',
            'jumlah_stok'               => 30
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 14,  
            'tanggal_kadaluarsa'        => '2022-12-06 00:00:00',
            'jumlah_stok'               => 34
        ]);

        DB::table('barang_has_kadaluarsa')->insert([
            'barang_id'                 => 15,  
            'tanggal_kadaluarsa'        => '2022-11-30 00:00:00',
            'jumlah_stok'               => 20
        ]);

        
    }

}
