<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Http;
use DB;

class pengirimanCheckCommand extends Command
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
        // $penjualan = DB::table('penjualan')
        //                 ->select('pen')
        //                 ->where('')
        //                 ->get();

        $cek_riwayat_pengiriman = Http::withHeaders([
            'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTY0ODQ1OTU4MH0.bA1sNlK7-qLnTV9h34PeA_MhD45k6a-gPyBqe0fQx28',
            ])->get("https://api.biteship.com/v1/trackings/".$pengiriman[0]->nomor_resi."/couriers/.".$pengiriman[0]->kode_shipper)->body();
    }
}
