<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use Session;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function cancel($nomorNota)
    {
        $cancel = \Midtrans\Transaction::cancel($nomorNota);
    }

    public function index()
    {
        $penjualan = DB::table('penjualan')->join('detail_penjualan', 'penjualan.nomor_nota', '=', 'detail_penjualan.nomor_nota')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->select('penjualan.nomor_nota', 'penjualan.tanggal', 'detail_penjualan.total', 'pembayaran.id as pembayaran_id', 'pembayaran.status')->where('penjualan.users_id', '=', auth()->user()->id)->orderByDesc('penjualan.tanggal')->distinct()->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        // $arrStatus = array();

        foreach($penjualan as $item)
        {
            $status = \Midtrans\Transaction::status($item->nomor_nota);

            $status_bayar = "";
            if($status->transaction_status == "pending")
            {
                $status_bayar = "Menunggu Pembayaran";
            }
            else if($status->transaction_status == "expire")
            {
                $status_bayar = "Pembayaran melewati batasan waktu";
            }
            else if($status->transaction_status == "failed")
            {
                $status_bayar = "Error";
            }
            else if($status->transaction_status == "settlement")
            {
                $status_bayar = "Sudah Dibayar";
            }

            $update_status = DB::table('pembayaran')->where('id', '=', $item->pembayaran_id)->update(['status' => $status_bayar]);

            // array_push($arrStatus, $status->transaction_status);
        }

        return view('pelanggan.user_menu.user_menu', ['order'=>$penjualan, 'total_cart'=>$total_cart]);
    }
    
    public function detailPayment(Request $request)
    {
        dd($request);
    }

    public function addOrderPickInStore(Request $request) 
    {   
        $current_status = \Midtrans\Transaction::status($request->nomor_nota);

        // kembali ke halaman sebelumnya jika pembayaran melalui e-wallet belum lunas
        if($current_status->payment_type == "gopay" || $current_status->payment_type == "qris")
        {
            if($current_status->status_code == "201" && $current_status->transaction_status == "pending")
            {
                $cancel = $this->cancel($request->nomor_nota);
                return redirect()->back()->with(['status' => 'Pembayaran melalui e-Wallet dari anda belum masuk. Harap ulangi pembayaran']);
            }
        }

        $status_message = $current_status->status_message;
        $transaction_time = $current_status->transaction_time;
        $metode_pembayaran = $current_status->payment_type;
        $transaction_status = $current_status->transaction_status;

        // $bank = $current_status['va_numbers'][0]['bank'];

        $batasan_waktu = new Carbon($transaction_time);

        if($metode_pembayaran == "bank_transfer")
        {
            $batasan_waktu = $batasan_waktu->addHours('3'); // batasan waktu sehari
        }
        else if ($metode_pembayaran == "gopay" || $metode_pembayaran == "qris")
        {
            $batasan_waktu = $batasan_waktu->addMinutes('15'); // batasan waktu sehari
        }

        try     
        {   
            $status = "";
            
            if($transaction_status == "settlement")
            {
                $status = "Pesanan sudah dibayar dan sedang disiapkan";
            }
            else if($transaction_status == "pending")
            {
                $status = "Menunggu pesanan dibayarkan";
            }
            else if ($transaction_status == "deny")
            {
                $status = "Pembayaran pesanan ditolak";
            }
            else if ($transaction_status == "expire")
            {
                $status = "Pembayaran pesanan melebihi batas waktu yang ditentukan";
            }
            else if ($transaction_status == "cancel")
            {
                $status = "Pesanan dibatalkan";
            }
            
            $cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->get();

            $id_pembayaran = null;
            if($metode_pembayaran == "bank_transfer")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'bank' => $current_status->va_numbers[0]->bank, 'nomor_rekening' => $current_status->va_numbers[0]->va_number, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "gopay")
            {
                // $link_qrcode = "https://api.sandbox.veritrans.co.id/v2/gopay/".$current_status->transaction_id."/qr-code";

                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "qris")
            {
                // $link_qrcode = "https://api.sandbox.veritrans.co.id/v2/qris/shopeepay/sppq_".$current_status->transaction_id."/qr-code";

                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }

            $insert_penjualan = DB::table('penjualan')->insert(['nomor_nota' => $request->nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'Ambil di toko', 'status'=>$status]);

            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'nomor_nota' => $request->nomor_nota,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal,
                    'total' => $cart[$i]->total
                ]);
            }

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            return redirect()->route('info_order', ['nomor_nota' => $request->nomor_nota]);
            // return view('pelanggan.order.status', ['status' => $status, 'batasan_waktu' => $batasan_waktu]);

        }
        catch(Exception $ex)
        {
            dd($ex);       
        }
        
    }

    public function infoOrder(Request $request)
    {
        $order = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*', 'detail_penjualan.total')->join('detail_penjualan', 'penjualan.nomor_nota', '=', 'detail_penjualan.nomor_nota')->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')->where('penjualan.nomor_nota', '=', $request->nomor_nota)->where('users_id', '=', auth()->user()->id)->get();
     
        if(count($order) == 0)
        {
            abort(404);
        }
        else
        {
            return view('pelanggan.order.status', ['penjualan' => $order]);
        }
    }

    public function addOrderShipment(Request $request) 
    {   
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

        $status = "";
        if($status_pembayaran == "pending")
        {
            $status = "menunggu_pembayaran";
        }
        else if($status_pembayaran == "expire")
        {
            $status = "gagal";
        }
        else if($status_pembayaran == "failed")
        {
            $status = "error";
        }
        else if($status_pembayaran == "success")
        {
            $status = "lunas";
        }

        try     
        {   
            $status = \Midtrans\Transaction::status($nomor_nota);

            $cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->get();

            $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'deadline' => $transaction_time, 'status' => $status_pembayaran]);

            $insert_penjualan = DB::table('penjualan')->insert(['nomor_nota' => $nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'dikirim']);

            $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif, 'status' => '-', 'kode_shipper' => $kode_shipper, 'jenis_pengiriman' => $jenis_pengiriman, 'total_berat' => $total_berat_pengiriman]);

            $insert_pengiriman = DB::table('multiple_pengiriman')->insert(['pengiriman_id'=>$id_pengiriman, 'alamat_pengiriman_id'=>$alamat_pengiriman_id, 'total_tarif'=>$tarif]);

            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'nomor_nota' => $nomor_nota,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal,
                    'pengiriman_id' => $id_pengiriman, 
                    'alamat_pengiriman_id' => $alamat_pengiriman_id,
                    'total' => $cart[$i]->total+$tarif
                ]);
            }

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            return view('pelanggan.order.status', ['status' => $status]);

        }
        catch(Exception $ex)
        {
            dd($ex);
            // abort(404);        
        }
    }

    public function next()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.order_method', ['cart'=>$cart, 'total_cart'=>$total_cart]);
    }

    public function shipment(Request $request)
    {
        $alamat_dipilih =  DB::table('alamat_pengiriman')->where('alamat_utama', '=', 1)->get();

        if($request->alamat_id != null)
        {
            $alamat_dipilih = DB::table('alamat_pengiriman')->select('*')->where('id','=',$request->alamat_id)->where('users_id', '=', auth()->user()->id)->get();
        }

        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'kategori_barang.kategori_barang as barang_kategori', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();
        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.kirim_ke_alamat', ['cart' => $cart, 'alamat'=>$alamat, 'alamat_dipilih'=>$alamat_dipilih]);
    }

    public function multipleShipmentNew(Request $request)
    {
        $update_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['alamat_pengiriman_id' => $request->alamat_tujuan_pengiriman]);

        return redirect('order/shipment/multiple');
    }

    public function multipleShipment()
    {
        // $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto_1 as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();

        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();
        $alamat = DB::table('alamat_pengiriman')->where('users_id', '=', auth()->user()->id)->get();


        // return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'alamat'=>$alamat, 'arr'=>$arr]);
        return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'alamat' => $alamat ]);

    }

    public function tes(Request $request)
    {
        return view('pelanggan.order.ngetes', ['data'=>json_decode($request->data)]);
    }

    public function pickInStore()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'kategori_barang.kategori_barang as barang_kategori', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.ambil_di_toko', ['cart' => $cart, 'total_cart'=>$total_cart]);
    }

    public function pickAddress(Request $request)
    {
        $barang = DB::table('barang')->where('id','=', $request->barang_id)->get();
        $cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->get();

        $insert_cart = DB::table('cart')->insert(['barang_id' => $request->barang_id, 'kuantitas' => 1, 'subtotal' => $barang[0]->harga_jual, 'total' => $cart[0]->total+$barang[0]->harga_jual, 'alamat_pengiriman_id'=>$request->alamat_id, 'users_id'=>auth()->user()->id]);
        // $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto_1 as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();
        // $alamat_dipilih = DB::table('alamat_pengiriman')->select('*')->where('id','=',$request->alamat_id)->where('users_id', '=', auth()->user()->id)->get();
        // $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        // dd($alamat_dipilih);

        return redirect()->route('multipleShipment');

    }

    public function show($nomor_nota)
    {
        try 
        {
            // Set your Merchant Server Key
            // \Midtrans\Config::$serverKey = 'SB-Mid-server-OU7Ua73QOqCZlOOe3209vIOt';
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            // \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            // \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            // \Midtrans\Config::$is3ds = true;

            $transaksi = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->where('penjualan.users_id', '=', auth()->user()->id)->where('penjualan.nomor_nota', '=', $nomor_nota)->get();

            $status = \Midtrans\Transaction::status($nomor_nota);

            $status_bayar = "";
            if($status->transaction_status == "pending")
            {
                $status_bayar = "menunggu_pembayaran";
            }
            else if($status->transaction_status == "expire")
            {
                $status_bayar = "gagal";
            }
            else if($status->transaction_status == "failed")
            {
                $status_bayar = "error";
            }
            else if($status->transaction_status == "success")
            {
                $status_bayar = "lunas";
            }

            $update_status = DB::table('pembayaran')->where('id', '=', $transaksi[0]->pembayaran_id)->update(['status' => $status_bayar]);

            $barang = DB::table('detail_penjualan')->select('detail_penjualan.*', 'barang.*')->where('detail_penjualan.nomor_nota', '=', $nomor_nota)->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')->get();

            return view('pelanggan.user_menu.order.detail', ['transaksi'=>$transaksi, 'barang'=>$barang]);
        }
        catch(Exception $ex)
        {
            dd($ex);
            // abort(404);
        }
        

    }
}
