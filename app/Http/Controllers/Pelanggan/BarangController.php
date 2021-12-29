<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class BarangController extends Controller
{
    public function showDetail($id)
    {
        $data_barang = DB::table('barang')->where('barang.id', '=', $id)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->select('barang.*', 'kategori_barang.kategori_barang', 'jenis_barang.jenis_barang', 'merek_barang.merek_barang')->get();
        $data_kategori = DB::table('kategori_barang')->get();
        $data_barang_serupa = DB::table('barang')->where('barang.jenis_id', '=', $data_barang[0]->jenis_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();
        $data_barang_lain = DB::table('barang')->where('barang.kategori_id', '=', $data_barang[0]->kategori_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();


        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
            $data_barang_wishlist = DB::Table('wishlist')->where('barang_id', '=', $id)->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'semua_kategori' => $data_kategori, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain, 'total_cart' => $total_cart, 'data_barang_wishlist' => $data_barang_wishlist]);
        }
        else
        {

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'semua_kategori' => $data_kategori, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain]);
        }
    }

    public function showPromo()
    {
        $data_barang = DB::table('barang')->where('diskon_potongan_harga', '>', 0)->inRandomOrder()->get();
        $data_jenis = DB::table('jenis_barang')->get();

        return view('pelanggan.shop.shop_by_type', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang]);
    }

    public function searchBarang(Request $request)
    {
        $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id','=','jenis_barang.id')->join('kategori_barang', 'barang.kategori_id','=','kategori_barang.id')->join('merek_barang', 'barang.merek_id','=','merek_barang.id')->where('nama', 'like', '%'.strtolower($request->key).'%')->where('kategori_barang.kategori_barang', '=', $request->input_kategori)->paginate(15);

        $data_merek = null;

        $data_kategori = DB::table('kategori_barang')->get();

        if(count($data_barang) > 0)
        {
            $data_merek = DB::table('merek_barang')->select('merek_barang.*')->join('barang', 'merek_barang.id', '=', 'barang.merek_id')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->where('kategori_barang.kategori_barang', '=', $request->input_kategori)->distinct()->get();   
        }

        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'total_cart' => $total_cart]);
        }
        else
        {
            return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'semua_kategori' => $data_kategori, 'barang' => $data_barang]);
        }

    }
}
