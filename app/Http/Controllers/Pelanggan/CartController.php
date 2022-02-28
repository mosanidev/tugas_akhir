<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

class CartController extends Controller
{
    public function update(Request $request)
    {
        // ambil data barang dari db
        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.nama', 'barang.foto', 'barang.harga_jual', 'barang.diskon_potongan_harga', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok_di_gudang) as jumlah_stok'))
                    ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->where('barang.id', '=', $request->barang_id)
                    ->get();

        $cart = null;

        if(Auth::check())
        {
            $update = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->where('barang_id', $request->barang_id)
                    ->update([
                        'subtotal'      => ($barang[0]->harga_jual-$barang[0]->diskon_potongan_harga)*$request->kuantitas,
                        'kuantitas'     => $request->kuantitas
                    ]);
    
            $total_cart = DB::table('cart')->select(DB::raw('sum(subtotal) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
    
            $update = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->update([
                        'total'         => $total_cart[0]->total_cart
                    ]);

            $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();
    
        }
        else
        {
            $cart = session()->get('cart');

            foreach($cart as $item)
            {
                if($item->barang_id == $request->barang_id)
                {
                    $item->subtotal  = $barang[0]->harga_jual*$request->kuantitas;
                    $item->kuantitas = $request->kuantitas;
                }
            }

            $total = 0;
            foreach($cart as $item)
            {
                $total += $item->subtotal;

            }

            foreach($cart as $item)
            {
                $item->total = $total;
            }

            session()->put('cart', $cart);

        }   

        return response()->json(['cart'=>$cart]);

    }

    public function remove(Request $request)
    {
        if(Auth::check())
        {
            $deleted = DB::table('cart')
                        ->where('barang_id', '=', $request->barang_id)
                        ->where('users_id', '=', auth()->user()->id)
                        ->delete();

            $total_cart = DB::table('cart')
                            ->select(DB::raw('sum(subtotal) as total_cart'))
                            ->where('users_id', '=', auth()->user()->id)
                            ->get();
    
            $update_total = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->update([
                        'total'         => $total_cart[0]->total_cart
                    ]);

        } 
        else
        {
            $cart = session()->get('cart');

            foreach($cart as $key => $item)
            {
                if($item->barang_id ==  $request->barang_id)
                {
                    // hapus elemen pada sebuah array
                    unset($cart[$key]);
                }
            }

            // hitung total 
            $total = 0;
            foreach($cart as $item)
            {
                $total += $item->subtotal;

            }

            foreach($cart as $item)
            {
                $item->total = $total;
            }

            session()->put('cart', $cart);

        }

        return response()->json(['status'=> 'Data berhasil dihapus']);
    }

    public function show()
    {
        $kategori = DB::table('kategori_barang')->get();

        if(Auth::check())
        {
            $cart = DB::table('cart')
                    ->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.diskon_potongan_harga as barang_diskon_potongan_harga', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok_di_gudang) as barang_stok'))
                    ->join('barang', 'cart.barang_id', '=', 'barang.id')
                    ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->where('cart.users_id', '=', auth()->user()->id)
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbon\Carbon::now())
                    ->groupBy('cart.barang_id')
                    ->get();

            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.cart.cart', ['cart' => $cart, 'semua_kategori' => $kategori, 'total_cart'=>$total_cart]);
        }
        else
        {
            return view('pelanggan.cart.cart', ['semua_kategori' => $kategori]);
        }
    }

    public function add(Request $request)
    {
        // ambil data barang dari db
        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.nama', 'barang.foto', 'barang.harga_jual', 'barang.diskon_potongan_harga', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok_di_gudang) as jumlah_stok'))
                    ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbon\Carbon::now())
                    ->where('barang.id', '=', $request->barang_id)
                    ->get();

        // buat variable untuk pemberitahuan status tambah barang ke keranjang
        $status = "";

        $qty = isset($request->qty) ? $request->qty : 1;

        $total_cart = 0;

        if(Auth::check()) // jika sudah login, masukkan data barang dan keranjang belanja langsung ke database
        {
            // query untuk memperoleh data keranjang belanja yang barangnya sama dan dimiliki oleh user yang sama dengan yang login
            $cart = DB::table('cart')
                    ->where('cart.barang_id', '=', $request->barang_id)
                    ->where('cart.users_id', '=', auth()->user()->id)
                    ->get();

            // query untuk memperoleh total barang di keranjang belanja milik user yang login
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
    
            // query untuk memperoleh total harga di keranjang belanja milik user yang login
            $total = DB::table('cart')->select(DB::raw('SUM(subtotal) as total'))->where('users_id', '=', auth()->user()->id)->get();
    
            // total harga di keranjang belanja ditambahkan dengan harga jual dari barang yang baru ditambahkan
            $total[0]->total += $barang[0]->harga_jual-$barang[0]->diskon_potongan_harga; 
    
            // jika total harga di keranjang belanja masih belum ada
            if($total[0]->total == null)
            {
                $total[0]->total = $barang[0]->harga_jual-$barang[0]->diskon_potongan_harga;
            } 
    
            // jika data keranjang belanja dengan data barang tersebut masih kosong
            if (count($cart) == 0)
            {
                $cart = DB::table('cart')->insert([
                    'barang_id'     => $request->barang_id,
                    'kuantitas'     => $qty,
                    'subtotal'      => $barang[0]->harga_jual-$barang[0]->diskon_potongan_harga,
                    'total'         => $total[0]->total,
                    'users_id'      => auth()->user()->id
                ]);

                $update = DB::table('cart')
                ->where('users_id', auth()->user()->id)
                ->update([
                    'total'         => $total[0]->total,
                ]);

                $status = "Barang berhasil dimasukkan ke keranjang";

            } 
            else
            {
                if ($cart[0]->kuantitas+$qty <= $barang[0]->jumlah_stok)
                {
                    $update = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->where('barang_id', $request->barang_id)
                    ->update([
                        'kuantitas' => $cart[0]->kuantitas+$qty,
                        'subtotal' => ($cart[0]->kuantitas+$qty)*($barang[0]->harga_jual-$barang[0]->diskon_potongan_harga)
                    ]);
    
                    $cart = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->update([
                        'total' => $total[0]->total
                    ]);
    
                    $status = "Jumlah barang berhasil ditambahkan di keranjang";
    
                }
                else 
                {
                    $status = "Maaf jumlah barang yang ditambahkan melebihi jumlah stok";
    
                }
            } 
        }
        else // jika user belum login data keranjang belanja disimpan di session terlebih dahulu
        {
            $cart = session()->get('cart');

            if ($cart == null)
            {
                $cart = array();
            }

            if(count($cart) == 0)
            {
                $cart[0] = (object) [
                    "barang_id" => $barang[0]->id,
                    "barang_nama" => $barang[0]->nama,
                    "barang_foto" => $barang[0]->foto,
                    "barang_harga" => $barang[0]->harga_jual,
                    "barang_diskon_potongan_harga" => $barang[0]->diskon_potongan_harga,
                    "kuantitas" => $qty,
                    "barang_stok" => $barang[0]->jumlah_stok,
                    "subtotal" => $barang[0]->harga_jual,
                    "total" => 0
                ];

                $status = "Barang berhasil dimasukkan ke keranjang";
                
            } 
            else
            {
                $find = "";

                $status = array();

                foreach($cart as $item)
                {
                    if($item->barang_id == $request->barang_id)
                    {
                        if ($item->kuantitas+$qty > $barang[0]->jumlah_stok)
                        {
                            $find = "true";

                            $item->kuantitas = $item->barang_stok;

                            $item->subtotal = $barang[0]->harga_jual*$item->kuantitas;
                            
                            $status = "Maaf jumlah barang yang ditambahkan melebihi jumlah stok";
                        } 
                        else
                        {
                            $find = "true";

                            $item->kuantitas+=$qty;

                            $status = "Jumlah barang berhasil ditambahkan di keranjang";
                        }

                        break;
                    }
                }

                if($find == "")
                {
                    $e = count($cart);

                    $cart[$e] = (object)[
                        "barang_id" => $barang[0]->id,
                        "barang_nama" => $barang[0]->nama,
                        "barang_foto" => $barang[0]->foto,
                        "barang_harga" => $barang[0]->harga_jual,
                        "barang_diskon_potongan_harga" => $barang[0]->diskon_potongan_harga,
                        "kuantitas" => $qty,
                        "barang_stok" => $barang[0]->jumlah_stok,
                        "subtotal" => $barang[0]->harga_jual,
                        "total" => 0
                    ];

                    $status = "Barang berhasil dimasukkan ke keranjang";

                }
            }

            // hitung total 
            $total = 0;
            foreach($cart as $item)
            {
                $total += $item->subtotal;

            }

            foreach($cart as $item)
            {
                $item->total = $total;
            }

            session()->put('cart', $cart);

            $total_cart = session()->get('cart');
        }

        return response()->json(['status'=>$status, 'total_cart'=>$total_cart]);
    }
}


