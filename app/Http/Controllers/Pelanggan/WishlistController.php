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
            return redirect()->back()->with(['error'=>'Harap login terlebih dahulu']);
        }
        
        $insert = DB::table('wishlist')->insert(['barang_id' => $request->id, 'users_id'=>auth()->user()->id]);
        
        return redirect()->back()->with(['success'=>'Berhasil ditambahkan di daftar wishlist']);
        
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
        dd($id);
        $delete = DB::table('wishlist')->where('id', '=', $id)->where('users_id', '=', auth()->user()->id)->delete();

        // return redirect()->route('detail', ['id'=>$id])->with(['status'=>'Dihapus di wishlist']);
        return redirect()->back()->with(['success'=>'Berhasil dihapus di daftar wishlist']);
    }

    public function deleteAll()
    {
        $delete = DB::table('wishlist')->where('users_id', '=', auth()->user()->id)->delete();
        return redirect()->back()->with(['status'=>'Berhasil dihapus di daftar wishlist']);
    }

    public function deleteByMarked(Request $request)
    {
        for($i = 0; $i < count($request->checkedWishlist); $i++)
        {
            $delete = DB::table('wishlist')->where('barang_id', '=', $request->checkedWishlist[$i])->where('users_id', '=', auth()->user()->id)->delete();
        }

        return response()->json(['success' => 'Dihapus semua boss']);
    }

}
