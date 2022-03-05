<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class KonsinyasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('konsinyasi')->delete();
        
        
    }
}
