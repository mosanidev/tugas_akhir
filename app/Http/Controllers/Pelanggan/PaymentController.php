<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use DB;

use Auth;

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
                        ->update(['status_jual' => 'Pembayaran diterima namun perlu pengecekan lebih lanjut oleh admin']);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                        ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            $updateNotif = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Pembayaran pesanan #".$penjualan[0]->nomor_nota." diterima namun perlu pengecekan lebih lanjut oleh admin",
                            'status' => 'Belum Dilihat'
                        ]);
        }
        else if($status == "paid" || $status == "captured")
        {
            $penjualan = DB::table('penjualan')
                            ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                            ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                            ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                            ->get();
            
            $updatePembayaran = DB::table('pembayaran')
                                ->where('id', $penjualan[0]->pembayaran_id)     
                                ->update([
                                    'status_bayar' => 'Sudah lunas',
                                    'waktu_lunas' => $notif->settlement_time
                                ]);

            $updatePenjualan = DB::table('penjualan')
                                ->where('nomor_nota', $notif->order_id)   
                                ->update(['status_jual' => 'Pesanan sudah dibayar']);

            $updateNotif = DB::table('notifikasi')
                            ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                            ->update([
                                'isi' => "Pesanan #".$penjualan[0]->nomor_nota." telah dibayar sedang menunggu pesanan diproses",
                                'status' => 'Belum Dilihat'
                            ]);
            
        }
        else if ($status == "pending")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status_jual' => 'Menunggu pesanan dibayarkan']);

        }
        else if ($status == "denied")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status_jual' => 'Pembayaran pesanan ditolak']);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                        ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            $updateNotif = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Pembayaran pesanan #".$penjualan[0]->nomor_nota." ditolak",
                            'status' => 'Belum Dilihat'
                        ]);
        }
        else if ($status == "expired")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status_jual' => 'Pembayaran pesanan melebihi batas waktu yang ditentukan']);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                        ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            $updateNotif = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan karena pembayaran pesanan melebihi batas waktu yang ditentukan",
                            'status' => 'Belum Dilihat'
                        ]);
        }
        else if ($status == "canceled")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status_jual' => 'Pesanan dibatalkan']);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                        ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            $updateNotif = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan oleh admin",
                            'status' => 'Belum Dilihat'
                        ]);
        }
        else if ($status == "failed")
        {
            $update = DB::table('penjualan')
                        ->where('nomor_nota', $notif->order_id)     
                        ->update(['status_jual' => 'Pembayaran pesanan gagal diproses']);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu')
                        ->where('penjualan.nomor_nota', '=', $notif->order_id) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            $updateNotif = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $penjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Mohon maaf terjadi kesalahan. Pesanan #".$penjualan[0]->nomor_nota." gagal diproses",
                            'status' => 'Belum Dilihat'
                        ]);
        }

    }

    
}
