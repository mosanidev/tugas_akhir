<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = DB::table('kategori_barang')->get();
        $wishlist = DB::table('wishlist')->select('wishlist.id', 'wishlist.barang_id', 'barang.foto', 'barang.nama', 'barang.diskon_potongan_harga', 'barang.harga_jual')->join('barang', 'wishlist.barang_id', '=', 'barang.id')->where('users_id','=',auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan..user_menu.user_menu', ['wishlist'=>$wishlist, 'semua_kategori' => $kategori, 'total_cart'=>$total_cart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check() == false)
        {
            return redirect()->back()->with(['status'=>'Harap login terlebih dahulu']);
        }
        
        $insert = DB::table('wishlist')->insert(['barang_id' => $request->id, 'users_id'=>auth()->user()->id, 'harga_barang'=>$request->harga_barang]);
        return redirect()->back()->with(['status'=>'Ditambahkan di wishlist']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('wishlist')->where('id', '=', $id)->where('users_id', '=', auth()->user()->id)->delete();

        // return redirect()->route('detail', ['id'=>$id])->with(['status'=>'Dihapus di wishlist']);
        return redirect()->back()->with(['status'=>'Dihapus di wishlist']);
    }

    public function deleteAll()
    {
        $delete = DB::table('wishlist')->where('users_id', '=', auth()->user()->id)->delete();
        return redirect()->back()->with(['status'=>'Dihapus di wishlist']);

    }

    public function deleteByMarked(Request $request)
    {
        for($i = 0; $i < count($request->checkedWishlist); $i++)
        {
            $delete = DB::table('wishlist')->where('barang_id', '=', $request->checkedWishlist[$i])->where('users_id', '=', auth()->user()->id)->delete();
        }

        return response()->json(['status' => 'Dihapus semua boss']);
    }

    public function beliByMarked(Request $request)
    {
        $barang = null;

        for($i = 0; $i<count($request->checkedWishlist[$i]); $i++)
        {
            $barang = DB::table('barang')->select('id', 'nama', 'foto_1', 'harga_jual', 'diskon_potongan_harga', 'jumlah_stok')->where('id', '=', $request->barang_id)->get();

        }
        // ambil data barang dari db

        // buat variable untuk pemberitahuan status tambah barang ke keranjang
        $status = "";

        $total_cart = 0;

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
                    'subtotal' => ($cart[0]->kuantitas+$qty)*$barang[0]->harga_jual-$barang[0]->diskon_potongan_harga
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
}
