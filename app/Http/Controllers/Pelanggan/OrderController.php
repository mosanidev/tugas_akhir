<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use Session;
use Auth;
use Carbon\Carbon;
use Http;

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
        $penjualan = DB::table('penjualan')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->select('penjualan.id', 'penjualan.nomor_nota', 'penjualan.tanggal', 'pembayaran.id as pembayaran_id', 'penjualan.status_jual as status_jual', 'penjualan.total', 'penjualan.metode_transaksi')->where('penjualan.users_id', '=', auth()->user()->id)->orderByDesc('penjualan.tanggal')->distinct()->paginate(10);

        $detail_penjualan = DB::table('detail_penjualan')
                            ->select('penjualan.nomor_nota', 'barang.nama', DB::raw('SUM(detail_penjualan.kuantitas) as kuantitas'))
                            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                            ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
                            ->where('penjualan.users_id', '=', auth()->user()->id)
                            ->groupBy('detail_penjualan.barang_id', 'detail_penjualan.penjualan_id')
                            ->get();

        $kategori = DB::table('kategori_barang')->get();
    
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
        
        $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['penjualan'=>$penjualan, 'detail_penjualan'=>$detail_penjualan, 'semua_kategori'=>$kategori, 'total_cart'=>$total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
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
                $status = "Pesanan sudah dibayar";
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
            
            $cart = DB::table('cart')
                        ->select('cart.*', 'barang.harga_jual', 'barang.diskon_potongan_harga')
                        ->where('users_id', '=', auth()->user()->id)
                        ->join('barang', 'barang.id', '=', 'cart.barang_id')
                        ->get();

            $id_pembayaran = null;

            if($metode_pembayaran == "bank_transfer")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "Transfer Bank", 'bank' => $current_status->va_numbers[0]->bank, 'nomor_rekening' => $current_status->va_numbers[0]->va_number, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "gopay" || $metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "E-Wallet", 'batasan_waktu' => $batasan_waktu]);
            }
            
            $dateNow = \Carbon\Carbon::now()->toDateTimeString();
            $id_penjualan = DB::table('penjualan')->insertGetId([
                                'nomor_nota' => $request->nomor_nota, 
                                'users_id' => auth()->user()->id, 
                                'tanggal' => $transaction_time,
                                'pembayaran_id' => $id_pembayaran, 
                                'metode_transaksi' => 'Ambil di toko', 
                                'status_jual'=>$status]);

            $total = 0;
            for($i = 0; $i < count($cart); $i++)
            {
                $qty= $cart[$i]->kuantitas*1;

                $dtBarang = DB::table('barang_has_kadaluarsa')
                                            ->where('barang_id', '=', $cart[$i]->barang_id)
                                            ->where('jumlah_stok_di_gudang','>',0)
                                            ->whereRaw('tanggal_kadaluarsa >= SYSDATE()')
                                            ->orderBy('tanggal_kadaluarsa','ASC')
                                            ->get();

                $tglKadaluarsaBrg = "";

                for ($j=0;$j<count($dtBarang);$j++)
                {
                    if ($qty>0)
                    {                        
                        if ($qty>$dtBarang[$j]->jumlah_stok_di_gudang)
                        {
                            $tglKadaluarsaBrg = $dtBarang[$j]->tanggal_kadaluarsa;
                            
                            $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                                'penjualan_id' => $id_penjualan,
                                'barang_id' => $cart[$i]->barang_id,
                                'tanggal_kadaluarsa' => $tglKadaluarsaBrg,
                                'kuantitas' => $dtBarang[$j]->jumlah_stok_di_gudang,
                                'subtotal' => ($cart[$i]->harga_jual-$cart[$i]->diskon_potongan_harga)*$dtBarang[$j]->jumlah_stok_di_gudang
                            ]);

                            $qty = $qty-$dtBarang[$j]->jumlah_stok_di_gudang;
                        }
                        else 
                        {
                            $tglKadaluarsaBrg = $dtBarang[$j]->tanggal_kadaluarsa;

                            $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                                'penjualan_id' => $id_penjualan,
                                'barang_id' => $cart[$i]->barang_id,
                                'tanggal_kadaluarsa' => $tglKadaluarsaBrg,
                                'kuantitas' => $qty,
                                'subtotal' => ($cart[$i]->harga_jual-$cart[$i]->diskon_potongan_harga)*$qty
                            ]);
                        }
                    }
                }

                $total = $cart[$i]->total;
            }

            $update_penjualan = DB::table('penjualan')->where('id', $id_penjualan)->update(['total' => $total]);

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu', 'penjualan.status_jual')
                        ->where('penjualan.id', '=', $id_penjualan) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            if($penjualan[0]->status_jual == "Pesanan sudah dibayar")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." telah dibayar sedang menunggu pesanan diproses",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);
            }
            else if($penjualan[0]->status_jual == "Menunggu pesanan dibayarkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Harap bayar pesanan #".$penjualan[0]->nomor_nota." sebelum tanggal ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('D MMMM Y')." jam ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('HH:mm')." WIB",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);
            }
            else if ($penjualan[0]->status_jual = "Pembayaran pesanan ditolak")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pembayaran pesanan #".$penjualan[0]->nomor_nota." ditolak",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);
            }
            else if ( $penjualan[0]->status_jual == "Pembayaran pesanan melebihi batas waktu yang ditentukan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan karena pembayaran pesanan melebihi batas waktu yang ditentukan",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);
            }
            else if ($penjualan[0]->status_jual == "Pesanan dibatalkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan oleh admin",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);
            }

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
        $order = DB::table('penjualan')
                        ->select('penjualan.*',
                                 'pembayaran.*',
                                 'penjualan.status_jual',
                                 'pembayaran.status_bayar')
                        ->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')
                        ->where('penjualan.nomor_nota', '=', $request->nomor_nota)
                        ->where('users_id', '=', auth()->user()->id)->get();
     
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
        $kode_jenis_pengiriman = $request->kode_jenis_pengiriman;
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
                $status = "Pesanan sudah dibayar";
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
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "Transfer Bank", 'bank' => $current_status->va_numbers[0]->bank, 'nomor_rekening' => $current_status->va_numbers[0]->va_number, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "gopay" || $metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "E-Wallet", 'batasan_waktu' => $batasan_waktu]);
            }

            $dateNow = \Carbon\Carbon::now()->toDateTimeString();

            $id_penjualan = DB::table('penjualan')
                                ->insertGetId([
                                    'nomor_nota' => $request->nomor_nota, 
                                    'users_id' => auth()->user()->id, 
                                    'tanggal' => $transaction_time,
                                    'pembayaran_id' => $id_pembayaran, 
                                    'metode_transaksi' => 'Dikirim ke alamat', 
                                    'status_jual' => $status]);

            $total = 0;

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif, 'kode_shipper' => $kode_shipper, 'kode_jenis_pengiriman' => $kode_jenis_pengiriman, 'jenis_pengiriman' => $jenis_pengiriman, 'total_berat' => $total_berat_pengiriman, 'estimasi_tiba' => $request->estimasi_tiba]);

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

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu', 'penjualan.status_jual')
                        ->where('penjualan.id', '=', $id_penjualan) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            if($penjualan[0]->status_jual == "Pesanan sudah dibayar")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." telah dibayar sedang menunggu pesanan diproses",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if($penjualan[0]->status_jual == "Menunggu pesanan dibayarkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Harap bayar pesanan #".$penjualan[0]->nomor_nota." sebelum tanggal ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('D MMMM Y')." jam ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('HH:mm')." WIB",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ($penjualan[0]->status_jual = "Pembayaran pesanan ditolak")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pembayaran pesanan #".$penjualan[0]->nomor_nota." ditolak",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ( $penjualan[0]->status_jual == "Pembayaran pesanan melebihi batas waktu yang ditentukan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan karena pembayaran pesanan melebihi batas waktu yang ditentukan",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ($penjualan[0]->status_jual == "Pesanan dibatalkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan oleh admin",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            
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
        $kode_jenis_pengiriman = json_decode($request->kode_jenis_pengiriman);
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
                $status = "Pesanan sudah dibayar";
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
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "Transfer Bank", 'bank' => $current_status->va_numbers[0]->bank, 'nomor_rekening' => $current_status->va_numbers[0]->va_number, 'batasan_waktu' => $batasan_waktu]);
            }
            else if ($metode_pembayaran == "gopay" || $metode_pembayaran == "qris")
            {
                $id_pembayaran = DB::table('pembayaran')->insertGetId(['metode_pembayaran' => "E-Wallet", 'batasan_waktu' => $batasan_waktu]);
            }

            $dateNow = \Carbon\Carbon::now()->toDateTimeString();

            $id_penjualan = DB::table('penjualan')
                                ->insertGetId([
                                    'nomor_nota' => $request->nomor_nota, 
                                    'users_id' => auth()->user()->id, 
                                    'tanggal' => $transaction_time,
                                    'pembayaran_id' => $id_pembayaran, 
                                    'metode_transaksi' => 'Dikirim ke berbagai alamat', 
                                    'status_jual'=>$status]);

            $total = 0;

            $delete_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->delete();

            $total_tarif = 0;

            $arrPengirimanId = [];

            $total_tarif = array_sum($tarif);
            
            for($i = 0; $i < count($data); $i++)
            {
                $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif[$i], 'kode_shipper' => $kode_shipper[$i], 'kode_jenis_pengiriman' => $kode_jenis_pengiriman[$i], 'jenis_pengiriman' => $jenis_pengiriman[$i], 'total_berat' => $total_berat_pengiriman[$i], 'estimasi_tiba' => $estimasi_tiba[$i]]);

                $insert_pengiriman = DB::table('multiple_pengiriman')->insert(['pengiriman_id'=>$id_pengiriman, 'alamat_pengiriman_id'=>$data[$i]->alamat_id, 'total_tarif'=>$total_tarif]);

                for($x = 0; $x < count($data[$i]->rincian); $x++)
                {
                    $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                        'penjualan_id' => $id_penjualan,
                        'barang_id' => $data[$i]->rincian[$x]->barang_id,
                        'kuantitas' => $data[$i]->rincian[$x]->kuantitas,
                        'subtotal' => $data[$i]->rincian[$x]->barang_harga*$data[$i]->rincian[$x]->kuantitas,
                        'pengiriman_id' => $id_pengiriman,
                        'alamat_pengiriman_id'=>$data[$i]->alamat_id
                    ]);

                    $total += $data[$i]->rincian[$x]->barang_harga*$data[$i]->rincian[$x]->kuantitas;
                }
                // $update_detail_penjualan = DB::table('detail_penjualan')->where('penjualan_id', $id_penjualan)->where('pengiriman_id', null)->update(['pengiriman_id' => $id_pengiriman, 'alamat_pengiriman_id'=>$alamat_pengiriman_id[$y]]);
            }

            $update_penjualan = DB::table('penjualan')->where('id', $id_penjualan)->update(['total' => $total+$total_tarif]);

            $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota', 'penjualan.users_id', 'penjualan.id as penjualan_id', 'pembayaran.id as pembayaran_id', 'pembayaran.batasan_waktu', 'penjualan.status_jual')
                        ->where('penjualan.id', '=', $id_penjualan) 
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->get();

            if($penjualan[0]->status_jual == "Pesanan sudah dibayar")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." telah dibayar sedang menunggu pesanan diproses",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                        ]);
            }
            else if($penjualan[0]->status_jual == "Menunggu pesanan dibayarkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Harap bayar pesanan #".$penjualan[0]->nomor_nota." sebelum tanggal ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('D MMMM Y')." jam ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('HH:mm')." WIB",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ($penjualan[0]->status_jual = "Pembayaran pesanan ditolak")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pembayaran pesanan #".$penjualan[0]->nomor_nota." ditolak",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ( $penjualan[0]->status_jual == "Pembayaran pesanan melebihi batas waktu yang ditentukan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan karena pembayaran pesanan melebihi batas waktu yang ditentukan",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            else if ($penjualan[0]->status_jual == "Pesanan dibatalkan")
            {
                $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$penjualan[0]->nomor_nota." dibatalkan oleh admin",
                            'penjualan_id' => $penjualan[0]->penjualan_id,
                            'users_id' => $penjualan[0]->users_id,
                            'status' => 'Belum dilihat',
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
            }
            
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
        $cart = DB::table('cart')
                ->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')
                ->join('barang', 'cart.barang_id', '=', 'barang.id')
                ->join('barang_has_kadaluarsa', 'cart.barang_id', '=', 'barang_has_kadaluarsa.barang_id')
                ->where('cart.users_id', '=', auth()->user()->id)
                ->groupBy('cart.barang_id')->get();

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

    public function pembayaranPotongGaji(Request $request) 
    {
        // $arrBarang = json_decode($request->arrBarang, true);
        // dd($arrBarang[0]['rincian']);
        // dd($request);

        if($request->metode_transaksi != "Dikirim ke berbagai alamat")
        {
            $alamat_pengiriman_id = isset($request->alamat_pengiriman_id) ? $request->alamat_pengiriman_id : null;
            $kode_shipper = isset($request->kode_shipper) ? $request->kode_shipper : null;
            $kode_jenis_pengiriman = isset($request->kode_jenis_pengiriman) ? $request->kode_jenis_pengiriman : null;
            $jenis_pengiriman = isset($request->jenis_pengiriman) ? $request->jenis_pengiriman : null;
            $total_berat = isset($request->total_berat) ? $request->total_berat : null;
            $estimasi_tiba = isset($request->estimasi_tiba) ? $request->estimasi_tiba : null;
            $tarif = isset($request->tarif) ? $request->tarif : null;
        }
        else 
        {
            $alamat_pengiriman_id = json_decode($request->alamat_pengiriman_id);
            $kode_shipper = json_decode($request->kode_shipper);
            $kode_jenis_pengiriman = json_decode($request->kode_jenis_pengiriman);
            $jenis_pengiriman = json_decode($request->jenis_pengiriman);
            $total_berat = json_decode($request->total_berat);
            $estimasi_tiba = json_decode($request->estimasi_tiba);
            $tarif = json_decode($request->tarif);
        }
        

        $idPengiriman = null;

        $idPembayaran = DB::table('pembayaran')
                            ->insertGetId([
                                'metode_pembayaran' => 'Pemotongan gaji',
                                'status_bayar' => 'Belum lunas'
                            ]);

        $idPenjualan = DB::table('penjualan')
                            ->insertGetId([
                                'nomor_nota' => $request->nomor_nota,
                                'users_id' => auth()->user()->id,
                                'tanggal' => Carbon::now(),
                                'pembayaran_id' => $idPembayaran,
                                'metode_transaksi' => $request->metode_transaksi,
                                'status_jual' => 'Pesanan sudah dibayar',
                                'created_at'=> Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'total' => $request->total_pesanan
                            ]);

        if($request->metode_transaksi == "Dikirim ke alamat")
        {
            $idPengiriman = DB::table('pengiriman')
                                ->insertGetId([
                                    'tarif' => $tarif,
                                    'kode_shipper' => $kode_shipper,
                                    'kode_jenis_pengiriman' => $request->kode_jenis_pengiriman,
                                    'jenis_pengiriman' => $request->jenis_pengiriman,
                                    'total_berat' => $request->total_berat,
                                    'estimasi_tiba' => $request->estimasi_tiba
                                ]);

            $insertMultiplePengiriman = DB::table('multiple_pengiriman')
                                            ->insert([
                                                'pengiriman_id' => $idPengiriman,
                                                'alamat_pengiriman_id' => $alamat_pengiriman_id,
                                                'total_tarif' => $tarif
                                            ]);
        }

        $arrBarang = json_decode($request->arrBarang, true);

        if($request->metode_transaksi != "Dikirim ke berbagai alamat")
        {
            for($i = 0; $i < count($arrBarang); $i++)
            {
                if($arrBarang['item_details'][$i]['name'] != 'Shipment Fee')
                {
                    $detailPenjualan = DB::table('detail_penjualan')
                                        ->insert([
                                            'penjualan_id' => $idPenjualan,
                                            'barang_id' => $arrBarang['item_details'][$i]['id'],
                                            'kuantitas' => $arrBarang['item_details'][$i]['quantity'],
                                            'subtotal' => $arrBarang['item_details'][$i]['price']*$arrBarang['item_details'][$i]['quantity'],
                                            'pengiriman_id' => $idPengiriman,
                                            'alamat_pengiriman_id' => $alamat_pengiriman_id
                                        ]);
                }
            }
        }
        else 
        {
            // untuk metode transaksi dikirim ke berbagai alamat

            $total_tarif = array_sum($tarif);

            for($i = 0; $i < count($arrBarang); $i++)
            {
                $id_pengiriman = DB::table('pengiriman')->insertGetId(['tarif' => $tarif[$i], 'kode_shipper' => $kode_shipper[$i], 'kode_jenis_pengiriman' => $kode_jenis_pengiriman[$i], 'jenis_pengiriman' => $jenis_pengiriman[$i], 'total_berat' => $total_berat, 'estimasi_tiba' => $estimasi_tiba[$i]]);

                $insert_pengiriman = DB::table('multiple_pengiriman')->insert(['pengiriman_id'=>$id_pengiriman, 'alamat_pengiriman_id'=>$arrBarang[$i]['alamat_id'], 'total_tarif'=>$total_tarif]);

                for($x = 0; $x < count($arrBarang[$i]['rincian']); $x++)
                {
                    $insert_detail_penjualan = DB::table('detail_penjualan')->insert([
                        'penjualan_id' => $idPenjualan,
                        'barang_id' => $arrBarang[$i]['rincian'][$x]['barang_id'],
                        'kuantitas' => $arrBarang[$i]['rincian'][$x]['kuantitas'],
                        'subtotal' => $arrBarang[$i]['rincian'][$x]['barang_harga']*$arrBarang[$i]['rincian'][$x]['kuantitas'],
                        'pengiriman_id' => $id_pengiriman,
                        'alamat_pengiriman_id'=>$arrBarang[$i]['alamat_id']
                    ]);
                }
            }
        }

        $deleteCart = DB::table('cart')
                        ->where('users_id', '=', auth()->user()->id)
                        ->delete();

        $insertNotif = DB::table('notifikasi')
                        ->insert([
                            'isi' => "Pesanan #".$request->nomor_nota." telah dibayar sedang menunggu pesanan diproses",
                            'penjualan_id' => $idPenjualan,
                            'users_id' => auth()->user()->id,
                            'created_at' => \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now(),
                            'status' => 'Belum dilihat'
                        ]);

        return redirect()->route('info_order', ['nomor_nota' => $request->nomor_nota]); 

    }

    public function shipment(Request $request)
    {
        $alamat_dipilih =  DB::table('alamat_pengiriman')->where('alamat_utama', '=', 1)->where('users_id', '=', auth()->user()->id)->get();

        if($request->alamat_id != null)
        {
            $alamat_dipilih = DB::table('alamat_pengiriman')->select('*')->where('id','=',$request->alamat_id)->where('users_id', '=', auth()->user()->id)->get();
        }

        $cart = DB::table('cart')
                ->select('cart.*', 'barang.nama as barang_nama', 'kategori_barang.kategori_barang as barang_kategori', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')
                ->join('barang', 'cart.barang_id', '=', 'barang.id')
                ->join('barang_has_kadaluarsa', 'cart.barang_id', '=', 'barang_has_kadaluarsa.barang_id')
                ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                ->where('cart.users_id', '=', auth()->user()->id)
                ->groupBy('cart.barang_id')->get();

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
        $update_cart = DB::table('cart')
                            ->where('users_id', '=', auth()->user()->id)
                            ->update(['alamat_pengiriman_id' => $request->alamat_tujuan_pengiriman]);

        return redirect('order/shipment/multiple');
    }

    public function multipleShipment()
    {
        $cart = DB::table('cart')
                ->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', DB::raw("sum(barang_has_kadaluarsa.jumlah_stok_di_gudang) as barang_stok"), 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan', 'alamat_pengiriman.*')
                ->join('barang', 'cart.barang_id', '=', 'barang.id')
                ->join('barang_has_kadaluarsa', 'cart.barang_id', '=', 'barang_has_kadaluarsa.barang_id')
                ->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')
                ->where('cart.users_id', '=', auth()->user()->id)->groupBy('cart.barang_id')
                ->get();

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
        $cart = DB::table('cart')
                ->select('cart.*', 'barang.nama as barang_nama', 'kategori_barang.kategori_barang as barang_kategori', 'barang.foto as barang_foto', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', 'barang.harga_jual as barang_harga', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')
                ->join('barang', 'cart.barang_id', '=', 'barang.id')
                ->join('barang_has_kadaluarsa', 'cart.barang_id', '=', 'barang_has_kadaluarsa.barang_id')
                ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                ->where('cart.users_id', '=', auth()->user()->id)
                ->groupBy('cart.barang_id')->get();

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
        $transaksi = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*', 'penjualan.status_jual as status_jual', 'pembayaran.status_bayar')->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')->where('penjualan.users_id', '=', auth()->user()->id)->where('penjualan.id', '=', $id)->get();

        $riwayat_pengiriman = null;

        $pengiriman = null;

        if($transaksi[0]->metode_transaksi == "Dikirim ke alamat")
        {
            $pengiriman = DB::table('detail_penjualan')
                            ->select('pengiriman.*', 'pengiriman.id as pengiriman_id', 'pengiriman.jenis_pengiriman', 'alamat_pengiriman.*', 'shipper.nama as nama_shipper')
                            ->where('detail_penjualan.penjualan_id', '=', $id)
                            ->join('pengiriman', 'detail_penjualan.pengiriman_id','=','pengiriman.id')
                            ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id','=','alamat_pengiriman.id')
                            ->join('shipper', 'pengiriman.kode_shipper','=','shipper.kode_shipper')
                            ->groupBy('detail_penjualan.alamat_pengiriman_id')
                            ->get();

            $barang = DB::table('detail_penjualan')
                            ->select('detail_penjualan.*', 'barang.*', 'pengiriman.*', 'alamat_pengiriman.*', DB::raw('sum(detail_penjualan.kuantitas) as kuantitas'), DB::raw('sum(detail_penjualan.subtotal) as subtotal'))
                            ->where('detail_penjualan.penjualan_id', '=', $id)
                            ->join('pengiriman', 'detail_penjualan.pengiriman_id','=','pengiriman.id')
                            ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id','=','alamat_pengiriman.id')
                            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                            ->groupBy('barang.id')
                            ->get();


        }
        else if ($transaksi[0]->metode_transaksi == "Ambil di toko")
        {
            $barang = DB::table('detail_penjualan')
                            ->select('detail_penjualan.*', 'barang.*', DB::raw('sum(detail_penjualan.kuantitas) as kuantitas'), DB::raw('sum(detail_penjualan.subtotal) as subtotal'))
                            ->where('detail_penjualan.penjualan_id', '=', $id)
                            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                            ->groupBy('barang.id')
                            ->get();

        }
        else if ($transaksi[0]->metode_transaksi == "Dikirim ke berbagai alamat")
        {
            $pengiriman = DB::table('detail_penjualan')
                            ->select('pengiriman.*', 'pengiriman.id as pengiriman_id', 'pengiriman.jenis_pengiriman', 'alamat_pengiriman.*', 'shipper.nama as nama_shipper')
                            ->where('detail_penjualan.penjualan_id', '=', $id)
                            ->join('pengiriman', 'detail_penjualan.pengiriman_id','=','pengiriman.id')
                            ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id','=','alamat_pengiriman.id')
                            ->join('shipper', 'pengiriman.kode_shipper','=','shipper.kode_shipper')
                            ->groupBy('detail_penjualan.alamat_pengiriman_id')
                            ->get();

            $barang = DB::table('detail_penjualan')
                        ->select('detail_penjualan.*', 'barang.*', 'pengiriman.*', 'alamat_pengiriman.*', DB::raw('sum(detail_penjualan.kuantitas) as kuantitas'), DB::raw('sum(detail_penjualan.subtotal) as subtotal'))
                        ->where('detail_penjualan.penjualan_id', '=', $id)
                        ->join('pengiriman', 'detail_penjualan.pengiriman_id','=','pengiriman.id')
                        ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id','=','alamat_pengiriman.id')
                        ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                        ->groupBy('barang.id')
                        ->get();

            $riwayat_pengiriman = [];

            foreach($pengiriman as $item)
            {
                if($item->nomor_resi != null)
                {
                    $cek_riwayat_pengiriman = Http::withHeaders([
                        'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
                        ])->get("https://api.biteship.com/v1/trackings/$item->nomor_resi/couriers/$item->kode_shipper")->body();
    
                    if($cek_riwayat_pengiriman->success == true)
                    {
                        // tracking via biteship melalui nomer resi
                        $hasil_riwayat_pengiriman = Http::withHeaders([
                            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
                            ])->get("https://api.biteship.com/v1/trackings/$pembelian[0]->nomor_resi/couriers/$pembelian[0]->kode_shipper")->body();

                        array_push($riwayat_pengiriman, json_decode($hasil_riwayat_pengiriman));
                    }
                }
            }

            
        }

        return response()->json(['transaksi'=>$transaksi, 'pengiriman' => $pengiriman, 'barang'=>$barang, 'riwayat_pengiriman'=> $riwayat_pengiriman]);


    }
}
