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
        $dateNow = \Carbon\Carbon::now();

        $periodeDiskon = DB::table('periode_diskon')
                         ->select('id')
                         ->whereDate('periode_diskon.tanggal_berakhir', '<', $dateNow)
                         ->get();

        foreach($periodeDiskon as $item)
        {
            $barang = DB::table('barang')
                        ->where('periode_diskon_id', '=', $item->id)
                        ->update(['diskon_potongan_harga' => 0, 
                                  'periode_diskon_id' => null]);
        }
        
    }
}
