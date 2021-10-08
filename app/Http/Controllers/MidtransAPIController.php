<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use DB;

class MidtransAPIController extends Controller
{
    public function pay(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

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

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(['snapToken'=>$snapToken, 'nomor_nota'=>$request->nomor_nota]);
     }
}
