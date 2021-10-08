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

        return view('pelanggan.user_menu.user_menu', ['order'=>$penjualan, 'total_cart'=>$total_cart, 'status_updated'=>$arrStatus]);
    }
    
    public function addOrderPickInStore(Request $request) 
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

    public function addOrderShipment(Request $request) 
    {   
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $alamat_pengiriman_id = $request->alamat_pengiriman_id;
        $tarif = $request->tarif;
        $kode_shipper = $request->kode_shipper;
        $jenis_pengiriman = $request->jenis_pengiriman;
        $total_berat_pengiriman = $request->total_berat_pengiriman;

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

            $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif, 'status' => '-', 'kode_shipper' => $kode_shipper, 'jenis_pengiriman' => $jenis_pengiriman, 'total_berat' => $total_berat_pengiriman, 'alamat_pengiriman_id' => $alamat_pengiriman_id]);

            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'nomor_nota' => $nomor_nota,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal,
                    'pengiriman_id' => $id_pengiriman, 
                    'total' => $cart[$i]->total+$tarif
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

        // $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        // $update_cart = DB::table('cart')->where('id', auth()->user()->id)->update(['alamat_pengiriman_id' => ]);

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.kirim_ke_alamat', ['cart' => $cart, 'alamat'=>$alamat]);

    }

    public function multipleShipmentNew(Request $request)
    {
        $update_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['alamat_pengiriman_id' => $request->alamat_tujuan_pengiriman]);

        return redirect('order/shipment/multiple');
    }

    public function multipleShipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        $alamat_selected = DB::table('alamat_pengiriman')->select('cart.barang_id', 'alamat_pengiriman.*')->join('cart', 'alamat_pengiriman.id', '=', 'cart.alamat_pengiriman_id')->get();

        dd($alamat_selected);
        // $arr = [];
        // for($i=0;$i<count($cart);$i++)
        // {
        //     $arr[$i] = array( 'id_barang' => $cart[$i]->barang_id,
        //                       'id_alamat' => $cart[$i]->alamat_pengiriman_id,
        //                        'alamat' => array('id' => $cart[$i]->alamat_pengiriman_id,
        //                                          'label' => ) );
        // }

        $arr = [];
        for($i=0;$i<count($cart);$i++)
        {
            $arr[$i] = array( 'id_barang' => $cart[$i]->barang_id,
                              'id_alamat' => $cart[$i]->alamat_pengiriman_id );
        }

        return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'alamat'=>$alamat, 'arr'=>$arr]);
    }

    public function pickInStore()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.id as barang_id', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.ambil_di_toko', ['cart' => $cart, 'total_cart'=>$total_cart]);
    }

    public function pickAddress(Request $request)
    {
        $total_keranjang = DB::table('cart')->select('total')->where('users_id', '=', auth()->user()->id)->get();
        $total_keranjang = $total_keranjang[0]->total;

        $harga_barang = DB::table('barang')->select('harga_jual')->where('id', '=', $request->barang_id)->get();
        $harga_barang = $harga_barang[0]->harga_jual;
        
        $new_total_keranjang = $total_keranjang+$harga_barang;

        $insert_cart = DB::table('cart')->insert(['barang_id' => $request->barang_id, 'kuantitas' => 1, 'subtotal' => $harga_barang, 'total' => $new_total_keranjang, 'users_id' => auth()->user()->id, 'alamat_pengiriman_id' => $request->alamat_id ]);
        
        $update_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['total' => $new_total_keranjang]);

        return redirect()->back();

        // $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.users_id', '=', auth()->user()->id)->where('cart.alamat_pengiriman_id', '=', $request->alamat_tujuan_pengiriman)->get();

        // $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        // $arr = [];
        // for($i=0;$i<count($cart);$i++)
        // {
        //     $arr[$i] = array( 'id_barang' => $cart[$i]->barang_id,
        //                       'id_alamat' => $cart[$i]->alamat_pengiriman_id);
        // }

        // return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'alamat'=>$alamat, 'arr'=>$arr]);

    }
}
