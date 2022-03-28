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
        $penjualan = DB::table('penjualan')
                        ->select('penjualan.id as penjualan_id', 'pengiriman.nomor_resi', 'shipper.kode_shipper')
                        ->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                        ->join('multiple_pengiriman', 'detail_penjualan.pengiriman_id', '=', 'multiple_pengiriman.pengiriman_id')
                        ->join('pengiriman', 'multiple_pengiriman.pengiriman_id', '=', 'pengiriman.id')
                        ->join('shipper', 'pengiriman.kode_shipper', '=', 'shipper.kode_shipper')
                        ->groupBy('penjualan.id')
                        ->get();

        foreach($penjualan as $item)
        {
            if($item->nomor_resi != null)
            {
                $cek_pengiriman = Http::withHeaders([
                    'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTY0ODQ1OTU4MH0.bA1sNlK7-qLnTV9h34PeA_MhD45k6a-gPyBqe0fQx28',
                    ])->get("https://api.biteship.com/v1/trackings/".$item->nomor_resi."/couriers/".$item->kode_shipper)->body();

                $cek_pengiriman = json_decode($cek_pengiriman);

                if($cek_pengiriman->status == "delivered")
                {
                    $update = DB::table('penjualan')
                                ->where('id', '=', $item->penjualan_id)
                                ->update([
                                    'status_jual' => 'Pesanan sudah selesai'
                                ]);
                }
            }
        }
    }
}
