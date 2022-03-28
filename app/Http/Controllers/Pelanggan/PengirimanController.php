<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Http;

class PengirimanController extends Controller
{
    public function lacakResi($id)
    {
        $pengiriman = DB::table('pengiriman')
                        ->select('shipper.nama as nama_shipper', 'pengiriman.*')
                        ->where('id', '=', $id)
                        ->join('shipper', 'pengiriman.kode_shipper', '=', 'shipper.kode_shipper')
                        ->get();

        if($pengiriman[0]->nomor_resi != null)
        {
            $cek_riwayat_pengiriman = Http::withHeaders([
                'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTY0ODQ1OTU4MH0.bA1sNlK7-qLnTV9h34PeA_MhD45k6a-gPyBqe0fQx28',
                ])->get("https://api.biteship.com/v1/trackings/".$pengiriman[0]->nomor_resi."/couriers/.".$pengiriman[0]->kode_shipper)->body();

            $cek_riwayat_pengiriman = json_decode($cek_riwayat_pengiriman);
                        
            if($cek_riwayat_pengiriman->success == true)
            {
                // tracking via biteship melalui nomer resi
                $riwayat_pengiriman = $cek_riwayat_pengiriman;
            } 
            else 
            {
                $riwayat_pengiriman = "Belum ada data pengiriman";
            }  
        }
        else 
        {
            // harus pake mode live bukan testing untuk tracking
            $cek_riwayat_pengiriman = Http::withHeaders([
                'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTY0ODQ1OTU4MH0.bA1sNlK7-qLnTV9h34PeA_MhD45k6a-gPyBqe0fQx28',
                ])->get("https://api.biteship.com/v1/trackings/JP2195194998/couriers/jnt")->body();
                // JP9480199312 
                // JD0166075143

            $cek_riwayat_pengiriman = json_decode($cek_riwayat_pengiriman); 

            if($cek_riwayat_pengiriman->success == true)
            {
                // tracking via biteship melalui nomer resi
                $riwayat_pengiriman = $cek_riwayat_pengiriman;
            } 
            else 
            {
                $riwayat_pengiriman = "Belum ada data pengiriman";
            }       
        }

        return response()->json(['pengiriman' => $pengiriman, 'riwayat_pengiriman' => $riwayat_pengiriman]);
    }
}
