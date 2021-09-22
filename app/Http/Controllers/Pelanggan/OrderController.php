<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use Session;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $penjualan = DB::table('penjualan')->join('detail_penjualan', 'penjualan.nomor_nota', '=', 'detail_penjualan.nomor_nota')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->select('penjualan.nomor_nota', 'penjualan.tanggal', 'detail_penjualan.total', 'pembayaran.status')->where('penjualan.users_id', '=', auth()->user()->id)->orderByDesc('penjualan.tanggal')->distinct()->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $arrStatus = array();
        foreach($penjualan as $item)
        {
            $status = \Midtrans\Transaction::status($item->nomor_nota);
    
            array_push($arrStatus, $status->transaction_status);
        }

        return view('pelanggan.user_menu', ['order'=>$penjualan, 'total_cart'=>$total_cart, 'status_updated'=>$arrStatus]);
    }
    
    public function status(Request $request) 
    {   
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $status_pembayaran = $request->result_type;
        $current_status = json_decode($request->result_data, true);
        $nomor_nota = $current_status['order_id'];
        $status_message = $current_status['status_message'];
        $transaction_time = $current_status['transaction_time'];
        $metode_pembayaran = $current_status['payment_type'];
        // $bank = $current_status['va_numbers'][0]['bank'];

        try     
        {   
            $status = \Midtrans\Transaction::status($nomor_nota);

            $cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->get();

            $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'waktu' => $transaction_time, 'status' => $status_pembayaran]);

            $insert_penjualan = DB::table('penjualan')->insert(['nomor_nota' => $nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'ambil_di_toko']);

            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'nomor_nota' => $nomor_nota,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal,
                    'total' => $cart[$i]->total
                ]);
            }

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            return view('pelanggan.order.status', ['status' => $status]);

        }
        catch(Exception $ex)
        {
            abort(404);        
        }
    }

    public function next()
    {
        if(Auth::check())
        {
            $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
    
            return view('pelanggan.order.order_method', ['cart'=>$cart, 'total_cart'=>$total_cart]);
        }
        else
        {
            return view('auth.login');
        }
    }

    public function shipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.kirim_ke_alamat', ['cart' => $cart, 'total_cart'=>$total_cart, 'alamat'=>$alamat]);

    }

    public function multipleShipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'total_cart'=>$total_cart, 'alamat'=>$alamat]);
    }

    public function pickInStore()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.id as barang_id', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.ambil_di_toko', ['cart' => $cart, 'total_cart'=>$total_cart]);
    }
}
