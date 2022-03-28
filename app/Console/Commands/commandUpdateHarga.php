<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class commandUpdateHarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $dateNow = Carbon/Carbon::now();

        // $periodeDiskon = DB::table('periode_diskon')
        //                  ->whereBetween('tanggal_dimulai', [''])

        // $hargaBrg = DB::table('barang')
        //                 ->whereNotNul('periode_diskon_id')
        //                 ->get();


        // if($dateNow )
    }
}
