<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;

class PaymentController extends Controller
{   
    public function __construct()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
    
    public function initPayment(Request $request) 
    {
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
            )
        );

        $params = array_merge($params, $request->arr_barang);

        $snapToken = "";

        try 
        {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        catch (\Exception $e)
        {
            $snapToken = $e->getMessage();
        }

        return response()->json(['snapToken'=>$snapToken, 'nomor_nota'=>$request->nomor_nota, 'params'=> $params]);
    }

    public function cancel(Request $request)
    {
        $cancel = \Midtrans\Transaction::cancel($request->nomor_nota);

        return redirect()->back()->with(['status' => 'Harap ulangi transaksi']);
    }

    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $settlement_time = $notif->settlement_time;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            return $this->changeStatus($notif, 'paid');
        } else if ($transaction == 'pending') {
            return $this->changeStatus($notif, 'pending');
        } else if ($transaction == 'deny') {
            return $this->changeStatus($notif, 'denied');
        } else if ($transaction == 'expire') {
            return $this->changeStatus($notif, 'expired');
        } else if ($transaction == 'cancel') {
            return $this->changeStatus($notif, 'canceled');
        }

    }
    
    private function changeStatus($notif, $status)
    {
        if($status == "paid")
        {
            $idPembayaran = DB::table('pembayaran')->select('pembayaran.id')->join('penjualan', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->where('penjualan.nomor_nota', '=', $notif->order_id)->get();

            $updatePenjualan = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pesanan sudah dibayar dan sedang disiapkan']);
            
            $updatePembayaran = DB::table('pembayaran')
                        ->where('id', $idPembayaran[0]->id)     
                        ->update(['waktu_lunas' => $notif->settlement_time]);
        }
        else if ($status == "pending")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Menunggu pesanan dibayarkan']);
        }
        else if ($status == "deny")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran pesanan ditolak']);
        }
        else if ($status == "expire")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran pesanan melebihi batas waktu yang ditentukan']);
        }
        else if ($status == "cancel")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pesanan dibatalkan']);
        }

    }

    
}
