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

        return response()->json(['cart'=>$cart]);

    }

    public function remove(Request $request)
    {
        $deleted = DB::table('cart')->where('barang_id', '=', $request->barang_id)->where('users_id', '=', auth()->user()->id)->delete();

        return response()->json(['status'=> 'Data berhasil dihapus']);
    }

    public function show()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.cart.cart', ['cart' => $cart, 'total_cart'=>$total_cart]);
    }

    public function shipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.cart.kirim_ke_alamat', ['cart' => $cart, 'total_cart'=>$total_cart, 'alamat'=>$alamat]);

    }

    public function multipleShipment()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.cart.multiple_shipment', ['cart' => $cart, 'total_cart'=>$total_cart, 'alamat'=>$alamat]);
    }

    public function pickInStore()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.cart.ambil_di_toko', ['cart' => $cart, 'total_cart'=>$total_cart]);
    }

    public function next()
    {
        $cart = DB::table('cart')->select('cart.*', 'barang.nama as barang_nama', 'barang.foto as barang_foto', 'barang.harga_jual as barang_harga', 'barang.jumlah_stok as barang_stok', 'barang.berat as barang_berat', 'barang.satuan as barang_satuan')->join('barang', 'cart.barang_id', '=', 'barang.id')->where('cart.users_id', '=', auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.cart.cart_method', ['cart'=>$cart, 'total_cart'=>$total_cart]);
    }

    public function add(Request $request)
    {
        $barang = DB::table('barang')->select('id', 'nama', 'foto', 'harga_jual', 'jumlah_stok')->where('id', '=', $request->barang_id)->get();

        $cart = DB::table('cart')->where('barang_id', '=', $request->barang_id)->where('users_id', '=', auth()->user()->id)->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $total = DB::table('cart')->select(DB::raw('SUM(subtotal) as total'))->where('users_id', '=', auth()->user()->id)->get();

        $status = "";

        $total[0]->total += $barang[0]->harga_jual; 

        if($total[0]->total == null)
        {
            $total[0]->total = $barang[0]->harga_jual;
        } 

        if (count($cart) == 0)
        {
            if (1 <= $barang[0]->jumlah_stok)
            {
                $cart = DB::table('cart')->insert([
                    'barang_id'     => $request->barang_id,
                    'kuantitas'     => 1,
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
                $status = "Maaf jumlah barang yang ditambahkan melebihi jumlah stok";
            }
        } 
        else
        {
            // $status="{{ $cart[0]->kuantitas+1 }}";
            if ($cart[0]->kuantitas+1 <= $barang[0]->jumlah_stok)
            {
                $update = DB::table('cart')
                ->where('users_id', auth()->user()->id)
                ->where('barang_id', $request->barang_id)
                ->update([
                    'kuantitas' => $cart[0]->kuantitas+1,
                    'subtotal' => ($cart[0]->kuantitas+1)*$barang[0]->harga_jual
                ]);

                $cart = DB::table('cart')
                ->where('users_id', auth()->user()->id)
                ->update([
                    'total' => $total[0]->total
                ]);

                $status = "Jumlah barang berhasil ditambahkan keranjang";

            }
            else 
            {
                $status = "Maaf jumlah barang yang ditambahkan melebihi jumlah stok";

            }
        } 
                                    
        return response()->json(['status'=>$status, 'total_cart'=>$total_cart]);
    }
}
