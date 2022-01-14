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
            'tanggal_kadaluarsa'        => '2022-02-13 00:00:00',
            'jumlah_stok'               => 5
        ]);
    }
}
