<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class BarangController extends Controller
{
    public function filter(Request $request)
    {
        $data_barang_filter = null;

        if ($request->merek == null)
        {
            $data_barang_filter = DB::table('barang')->whereBetween('harga_jual', [$request->hargamin, $request->hargamax])->get();

        } 
        else if ($request->hargamin == null || $request->hargamax == null)
        {
            $data_barang_filter = DB::table('barang')->whereIn('merek_id', $request->merek)->get();
        }
        else 
        {
            $data_barang_filter = DB::table('barang')->whereIn('merek_id', $request->merek)->whereBetween('harga_jual', [$request->hargamin, $request->hargamax])->get();
        }

        $data_merek = DB::table('barang')->select('barang.merek_id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $request->kategori_id)->distinct()->get();

        return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'barang' => $data_barang_filter, 'id' => $request->kategori_id, 'merek_checked' => $request->merek, 'hargamin' => $request->hargamin, 'hargamax' => $request->hargamax]);

    }

    public function showRandom()
    {
        $data_jenis = DB::table('jenis_barang')->get();
        $data_barang = DB::table('barang')->inRandomOrder()->paginate(51);

        return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'barang' => $data_barang]); 
    }

    public function showDetail($id)
    {
        $data_barang = DB::table('barang')->where('barang.id', '=', $id)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->select('barang.*', 'kategori_barang.kategori_barang', 'jenis_barang.jenis_barang', 'merek_barang.merek_barang')->get();
        $data_barang_serupa = DB::table('barang')->where('barang.jenis_id', '=', $data_barang[0]->jenis_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();
        $data_barang_lain = DB::table('barang')->where('barang.kategori_id', '=', $data_barang[0]->kategori_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();
        
        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('sum(subtotal) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain, 'total_cart' => $total_cart]);
        }
        else
        {
            return view('pelanggan.product_detail', ['barang' => $data_barang, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain]);
        }
    }

    public function showPromo()
    {
        $data_barang = DB::table('barang')->where('diskon_potongan_harga', '>', 0)->inRandomOrder()->get();
        $data_jenis = DB::table('jenis_barang')->get();

        return view('pelanggan.shop', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang]);
    }

    public function searchBarang(Request $request)
    {
        $data_jenis = DB::table('jenis_barang')->get();
        $data_barang = DB::table('barang')->where('nama', 'like', '%'.strtolower($request->nama_barang_search).'%')->get();
        // $data_barang = DB::table('barang')->where('nama', '=', $request->nama_barang_search)->get();

        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('sum(subtotal) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.shop', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang, 'total_cart' => $total_cart]);
        }
        else
        {
            return view('pelanggan.shop', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang]);
        }

    }
}
