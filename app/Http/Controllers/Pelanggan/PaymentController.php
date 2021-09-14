<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

// use midtrans\midtrans;
// require_once base_path('vendor/midtrans/midtrans-php/Midtrans/Config.php');


class PaymentController extends Controller
{   
    public function initPayment() 
    {
        $server_key = env('MIDTRANS_SERVER_KEY');
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = $server_key;
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // try {
            
        //     print_r(json_decode($snapToken));
        // } catch (Exception $e) {
        //     dd($e);

        // }

    }
    

    
}
