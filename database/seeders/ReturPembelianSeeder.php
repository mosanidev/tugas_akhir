<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ReturPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('retur_pembelian')->delete();

        
    }
}
