<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PeriodeDiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periode_diskon')->delete();

    }
}
