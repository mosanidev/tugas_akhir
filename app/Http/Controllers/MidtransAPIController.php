<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use DB;

class MidtransAPIController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function pay(Request $request)
    {
        $snapToken = "";

        $params = array(
            'transaction_details' => array(
                'order_id' => $request->nomor_nota,
                'gross_amount' => $request->total_pesanan,
            ),
            'customer_details' => array(
                'first_name' => auth()->user()->nama_depan,
                'last_name' => auth()->user()->nama_belakang,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->nomor_telepon,
            ),
            // 'item_details' => array()
        );

        // for($i=0; $i<count($request->barang_id); $i++)
        // {
        //     array_push($params['item_details'], array(
        //             "id" => $request->barang_id[$i],
        //             "price" => (int)$request->barang_harga[$i]/(int)explode(" ", $request->barang_kuantitas[$i])[0],
        //             "quantity" => (int)explode(" ", $request->barang_kuantitas[$i])[0],
        //             "name" => $request->barang_nama[$i],
        //             "merchant_name" => "kobama jaya"
        //         )
        //     );
        // }  

        try 
        {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        catch (\Exception $e)
        {
            $snapToken = $e->getMessage();
        }

        return response()->json(['snapToken'=>$snapToken, 'nomor_nota'=>$request->nomor_nota]);
     }

     public function coba(Request $request)
     {
        dd($request);
     }
}
