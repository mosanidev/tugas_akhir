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
        $penjualan = DB::table('penjualan')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->select('penjualan.id', 'penjualan.nomor_nota', 'penjualan.tanggal', 'pembayaran.id as pembayaran_id', 'penjualan.status', 'penjualan.total')->where('penjualan.users_id', '=', auth()->user()->id)->orderByDesc('penjualan.tanggal')->distinct()->paginate(10);

        $detail_penjualan = DB::table('detail_penjualan')->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')->where('penjualan.users_id', '=', auth()->user()->id)->get();

        $kategori = DB::table('kategori_barang')->get();
    
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['penjualan'=>$penjualan, 'detail_penjualan'=>$detail_penjualan, 'semua_kategori'=>$kategori, 'total_cart'=>$total_cart]);
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
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }
            
            $dateNow = \Carbon\Carbon::now()->toDateTimeString();
            $id_penjualan = DB::table('penjualan')->insertGetId(['nomor_nota' => $request->nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'Ambil di toko', 'status'=>$status, 'created_at'=>$dateNow]);

            $total = 0;
            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'penjualan_id' => $id_penjualan,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal
                ]);

                $total = $cart[$i]->total;
            }

            $update_penjualan = DB::table('penjualan')->where('id', $id_penjualan)->update(['total' => $total]);

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
        $order = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*')->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')->where('penjualan.nomor_nota', '=', $request->nomor_nota)->where('users_id', '=', auth()->user()->id)->get();
     
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

        // data pengiriman
        $alamat_pengiriman_id = $request->alamat_pengiriman_id;
        $tarif = $request->tarif;
        $kode_shipper = $request->kode_shipper;
        $jenis_pengiriman = $request->jenis_pengiriman;
        $total_berat_pengiriman = $request->total_berat_pengiriman;

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
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }

            $dateNow = \Carbon\Carbon::now()->toDateTimeString();

            $id_penjualan = DB::table('penjualan')->insertGetId(['nomor_nota' => $request->nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'Dikirim ke alamat', 'status'=>$status, 'created_at'=>$dateNow]);

            $total = 0;

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif, 'kode_shipper' => $kode_shipper, 'jenis_pengiriman' => $jenis_pengiriman, 'total_berat' => $total_berat_pengiriman, 'estimasi_tiba' => $request->estimasi_tiba]);

            $insert_pengiriman = DB::table('multiple_pengiriman')->insert(['pengiriman_id'=>$id_pengiriman, 'alamat_pengiriman_id'=>$alamat_pengiriman_id, 'total_tarif'=>$tarif]);

            for($i = 0; $i < count($cart); $i++)
            {
                $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                    'penjualan_id' => $id_penjualan,
                    'barang_id' => $cart[$i]->barang_id,
                    'kuantitas' => $cart[$i]->kuantitas,
                    'subtotal' => $cart[$i]->subtotal,
                    'pengiriman_id' => $id_pengiriman,
                    'alamat_pengiriman_id' => $alamat_pengiriman_id
                ]);

                $total = $cart[$i]->total;
            }

            $update_penjualan = DB::table('penjualan')->where('id', $id_penjualan)->update(['total' => $total+$tarif]);

            return redirect()->route('info_order', ['nomor_nota' => $request->nomor_nota]);

        }
        catch(Exception $ex)
        {
            dd($ex);
            // abort(404);        
        }
    }

    public function addOrderMultipleShipment(Request $request)
    {
        $current_status = \Midtrans\Transaction::status($request->nomor_nota);

        // kembali ke halaman sebelumnya jika pembayaran melalui e-wallet belum lunas
        if($current_status->payment_type == "gopay" || $current_status->payment_type == "qris")
        {
            if($current_status->status_code == "201" && $current_status->transaction_status == "pending")
            {
                $cancel = $this->cancel($request->nomor_nota);
                return redirect()->back()->with(['error' => 'Pembayaran melalui e-Wallet dari anda belum masuk. Harap ulangi pembayaran']);
            }
        }

        $status_message = $current_status->status_message;
        $transaction_time = $current_status->transaction_time;
        $metode_pembayaran = $current_status->payment_type;
        $transaction_status = $current_status->transaction_status;

        // data pengiriman
        $data = json_decode($request->data);
        $alamat_pengiriman_id = json_decode($request->alamat_pengiriman_id);
        $tarif = json_decode($request->tarif);
        $kode_shipper = json_decode($request->kode_shipper);
        $jenis_pengiriman = json_decode($request->jenis_pengiriman);
        $estimasi_tiba = json_decode($request->estimasi_tiba);
        $total_berat_pengiriman = $request->total_berat_pengiriman;

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

            $id_pembayaran = null;

            if($metode_pembayaran == "bank_transfer")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'bank' => $current_status->va_numbers[0]->bank, 'nomor_rekening' => $current_status->va_numbers[0]->va_number, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "gopay")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => $metode_pembayaran, 'batasan_waktu' => $batasan_waktu]);
            }

            $dateNow = \Carbon\Carbon::now()->toDateTimeString();

            $id_penjualan = DB::table('penjualan')->insertGetId(['nomor_nota' => $request->nomor_nota, 'users_id' => auth()->user()->id, 'tanggal' => $transaction_time,'pembayaran_id' => $id_pembayaran, 'metode_transaksi' => 'Dikirim ke berbagai alamat', 'status'=>$status, 'created_at'=>$dateNow]);

            $total = 0;

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            $total_tarif = 0;

            $arrPengirimanId = [];

            

            $total_tarif = array_sum($tarif);

            for($y = 0; $y < count($alamat_pengiriman_id); $y++)
            {
                $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif[$y], 'kode_shipper' => $kode_shipper[$y], 'jenis_pengiriman' => $jenis_pengiriman[$y], 'total_berat' => $total_berat_pengiriman[$y], 'estimasi_tiba' => $estimasi_tiba[$y]]);

                $insert_pengiriman = DB::table('multiple_pengiriman')->insert(['pengiriman_id'=>$id_pengiriman, 'alamat_pengiriman_id'=>$alamat_pengiriman_id[$y], 'total_tarif'=>$total_tarif]);

                for($i=0; $i<count($data); $i++)
                {
                    for($x = 0; $x < count($data[$i]->rincian); $x++)
                    {
                        $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                            'penjualan_id' => $id_penjualan,
                            'barang_id' => $data[$i]->rincian[$x]->barang_id,
                            'kuantitas' => $data[$i]->rincian[$x]->kuantitas,
                            'subtotal' => $data[$i]->rincian[$x]->barang_harga*$data[$i]->rincian[$x]->kuantitas,
                            'pengiriman_id' => $id_pengiriman,
                            'alamat_pengiriman_id' => $alamat_pengiriman_id[$y]
                        ]);

                        $total += $data[$i]->rincian[$x]->barang_harga*$data[$i]->rincian[$x]->kuantitas;
                    }
                }
                // $update_detail_penjualan = DB::table('detail_penjualan')->where('penjualan_id', $id_penjualan)->update(['pengiriman_id' => $id_pengiriman, 'alamat_pengiriman_id'=>$alamat_pengiriman_id[$y]]);

            }

            $update_penjualan = DB::table('penjualan')->where('id', $id_penjualan)->update(['total' => $total+$total_tarif]);

            return redirect()->route('info_order', ['nomor_nota' => $request->nomor_nota]);

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

        if(count($cart) == 0)
        {
            abort(404);
        }
        else 
        {
            return view('pelanggan.order.order_method', ['cart'=>$cart, 'total_cart'=>$total_cart]);
        }
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

        if(count($cart) == 0)
        {
            abort(404);
        }
        else 
        {
            return view('pelanggan.order.kirim_ke_alamat', ['cart' => $cart, 'alamat'=>$alamat, 'alamat_dipilih'=>$alamat_dipilih]);
        }
    }

    public function multipleShipmentNew(Request $request)
    {
        $update_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['alamat_pengiriman_id' => $request->alamat_tujuan_pengiriman]);

        return redirect('order/shipment/multiple');
    }

    public function multipleShipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->orderBy('barang.jumlah_stok', 'asc')->get();

        $alamat = DB::table('alamat_pengiriman')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.order.multiple_shipment', ['cart' => $cart, 'alamat' => $alamat ]);
    }

    public function tes(Request $request)
    {        
        $dataFull = json_decode($request->dataFull);

        $dataJumlah = json_decode($request->dataJumlah);

        return view('pelanggan.order.ngetes', ['data'=>$dataFull, 'dataJumlah' => $dataJumlah]);
    }

    public function pickInStore()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'kategori_barang.kategori_barang as barang_kategori', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        if(count($cart) == 0)
        {
            abort(404);
        }
        else 
        {
            return view('pelanggan.order.ambil_di_toko', ['cart' => $cart, 'total_cart'=>$total_cart]);
        }
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

    public function show($id)
    {
        $transaksi = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->where('penjualan.users_id', '=', auth()->user()->id)->where('penjualan.id', '=', $id)->get();

        if($transaksi[0]->metode_transaksi == "Dikirim ke alamat")
        {
            $barang = DB::table('detail_penjualan')->select('detail_penjualan.*', 'barang.*', 'pengiriman.*', 'alamat_pengiriman.*', 'shipper.nama as nama_shipper')->where('detail_penjualan.penjualan_id', '=', $id)->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')->join('pengiriman', 'detail_penjualan.pengiriman_id','=','pengiriman.id')->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id','=','alamat_pengiriman.id')->join('shipper', 'pengiriman.kode_shipper','=','shipper.kode_shipper')->get();
        }
        else 
        {
            $barang = DB::table('detail_penjualan')->select('detail_penjualan.*', 'barang.*')->where('detail_penjualan.penjualan_id', '=', $id)->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')->get();
        }

        return response()->json(['transaksi'=>$transaksi, 'barang'=>$barang]);
    }
}
