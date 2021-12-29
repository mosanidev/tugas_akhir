<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;

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

        if(isset($request->arr_shipping_address))
        {
            $params = array_merge($params, $request->arr_shipping_address);
        }

        $snapToken = "";

        try 
        {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }
        catch (\Exception $e)
        {
            $snapToken = $e->getMessage();
        }

        return response()->json(['snapToken'=>$snapToken, 'nomor_nota'=>$request->nomor_nota, 'params'=> $params, 'total_pesanan' => $request->total_pesanan, 'serverKey' => env('MIDTRANS_SERVER_KEY')]);
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
                    return $this->changeStatus($notif, 'challenged');
                } else {
                    return $this->changeStatus($notif, 'captured');
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
        } else if ($transaction == 'failure') {
            return $this->changeStatus($notif, 'failed');
        }

    }
    
    private function changeStatus($notif, $status)
    {
        $dateNow = \Carbon\Carbon::now()->toDateTimeString();

        if($status == "challenged")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran diterima namun perlu pengecekan lebih lanjut oleh admin', 'updated_at' => $dateNow]);
        }
        else if($status == "paid" || $status == "captured")
        {
            $penjualan = DB::table('penjualan')->where('nomor_nota', '=', $notif->order_id)->get();

            $idPembayaran = DB::table('pembayaran')->select('pembayaran.id')->join('penjualan', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->where('penjualan.nomor_nota', '=', $notif->order_id)->get();
            
            $updatePembayaran = DB::table('pembayaran')
                                ->where('id', $idPembayaran[0]->id)     
                                ->update(['waktu_lunas' => $notif->settlement_time]);

            $updatePenjualan = DB::table('penjualan')
                                ->where('nomor_nota', $notif->order_id)   
                                ->update(['status' => 'Pesanan sudah dibayar dan sedang disiapkan', 'updated_at' => $dateNow]);
            
        }
        else if ($status == "pending")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Menunggu pesanan dibayarkan', 'updated_at' => $dateNow]);
        }
        else if ($status == "denied")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran pesanan ditolak', 'updated_at' => $dateNow]);
        }
        else if ($status == "expired")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran pesanan melebihi batas waktu yang ditentukan', 'updated_at' => $dateNow]);
        }
        else if ($status == "canceled")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pesanan dibatalkan', 'updated_at' => $dateNow]);
        }
        else if ($status == "failed")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status' => 'Pembayaran pesanan gagal diproses', 'updated_at' => $dateNow]);
        }

    }

    
}
