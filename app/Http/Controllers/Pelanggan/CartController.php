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
        $barang = DB::table('barang')->select('id', 'nama', 'foto', 'harga_jual', 'jumlah_stok')->where('id', '=', $request->barang_id)->get();

        $cart = null;

        if(Auth::check())
        {
            $update = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->where('barang_id', $request->barang_id)
                    ->update([
                        'subtotal'      => $barang[0]->harga_jual*$request->kuantitas,
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

            for($i=0; $i<count($cart); $i++)
            {
                if($cart[$i]->barang_id == $request->barang_id)
                {
                    $cart[$i]->subtotal  = $barang[0]->harga_jual*$request->kuantitas;
                    $cart[$i]->kuantitas = $request->kuantitas;
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
            $deleted = DB::table('cart')->where('barang_id', '=', $request->barang_id)->where('users_id', '=', auth()->user()->id)->delete();

            $total_cart = DB::table('cart')->select(DB::raw('sum(subtotal) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
    
            $update_total = DB::table('cart')
                    ->where('users_id', auth()->user()->id)
                    ->update([
                        'total'         => $total_cart[0]->total_cart
                    ]);

        } 
        else
        {
            $cart = session()->get('cart');

            for($i=0; $i<count($cart); $i++)
            {
                if($cart[$i]->barang_id == $request->barang_id)
                {
                    // hapus elemen pada sebuah array
                    unset($cart[$i]);
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
        if(Auth::check())
        {
            $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.cart.cart', ['cart' => $cart, 'total_cart'=>$total_cart]);
        }
        else
        {
            return view('pelanggan.cart.cart');
        }
    }

    public function add(Request $request)
    {
        // ambil data barang dari db
        $barang = DB::table('barang')->select('id', 'nama', 'foto', 'harga_jual', 'jumlah_stok')->where('id', '=', $request->barang_id)->get();

        // buat variable untuk pemberitahuan status tambah barang ke keranjang
        $status = "";

        $qty = isset($request->qty) ? $request->qty : 1;

        $total_cart = 0;

        if(Auth::check()) // jika sudah login, masukkan data barang dan keranjang belanja langsung ke database
        {
            // query untuk memperoleh data keranjang belanja yang barangnya sama dan dimiliki oleh user yang sama dengan yang login
            $cart = DB::table('cart')->where('barang_id', '=', $request->barang_id)->where('users_id', '=', auth()->user()->id)->get();

            // query untuk memperoleh total barang di keranjang belanja milik user yang login
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
    
            // query untuk memperoleh total harga di keranjang belanja milik user yang login
            $total = DB::table('cart')->select(DB::raw('SUM(subtotal) as total'))->where('users_id', '=', auth()->user()->id)->get();
    
            // total harga di keranjang belanja ditambahkan dengan harga jual dari barang yang baru ditambahkan
            $total[0]->total += $barang[0]->harga_jual; 
    
            // jika total harga di keranjang belanja masih belum ada
            if($total[0]->total == null)
            {
                $total[0]->total = $barang[0]->harga_jual;
            } 
    
            // jika data keranjang belanja dengan data barang tersebut masih kosong
            if (count($cart) == 0)
            {
                $cart = DB::table('cart')->insert([
                    'barang_id'     => $request->barang_id,
                    'kuantitas'     => $qty,
                    'subtotal'      => $barang[0]->harga_jual,
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
                        'subtotal' => ($cart[0]->kuantitas+$qty)*$barang[0]->harga_jual
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

                for($i=0; $i<count($cart); $i++)
                {
                    if($cart[$i]->barang_id == $request->barang_id)
                    {
                        if ($cart[$i]->kuantitas+$qty > $barang[0]->jumlah_stok)
                        {
                            $find = "true";

                            $cart[$i]->kuantitas = $cart[$i]->barang_stok;

                            $cart[$i]->subtotal = $barang[0]->harga_jual*$cart[$i]->kuantitas;
                            
                            $status = "Maaf jumlah barang yang ditambahkan melebihi jumlah stok";
                        } 
                        else
                        {
                            $find = "true";

                            $cart[$i]->kuantitas+=$qty;

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

            $total_cart =   (session()->get('cart'));
        }

        if($request->qty != null)
        {
            return redirect()->back()->with('status', $status);
        }
        else 
        {
            return response()->json(['status'=>$status, 'total_cart'=>$total_cart]);
        }
    }
}


