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

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();

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

        $data_merek = DB::table('barang')->select('merek_barang.id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $request->kategori_id)->distinct()->get();

        return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'barang' => $data_barang_filter, 'id' => $request->kategori_id, 'merek_checked' => $request->merek, 'hargamin' => $request->hargamin, 'hargamax' => $request->hargamax, 'barang_search'=>$data_barang_search]);

    }

    public function showRandom()
    {
        $curDate = \Carbon\Carbon::now()->format("Y-m-d");

        $data_jenis = DB::table('jenis_barang')->get();

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();      
    
        $data_barang = DB::table('barang')->select('barang.*')->where('barang.jumlah_stok', '>', 0)->inRandomOrder()->paginate(15);  

        $total_cart = null;

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'barang' => $data_barang, 'barang_search'=>$data_barang_search, 'total_cart'=>$total_cart]); 
    }

    public function showDetail($id)
    {
        $data_barang = DB::table('barang')->where('barang.id', '=', $id)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->select('barang.*', 'kategori_barang.kategori_barang', 'jenis_barang.jenis_barang', 'merek_barang.merek_barang')->get();
        $data_barang_serupa = DB::table('barang')->where('barang.jenis_id', '=', $data_barang[0]->jenis_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();
        $data_barang_lain = DB::table('barang')->where('barang.kategori_id', '=', $data_barang[0]->kategori_id)->whereNotIn('id', [$data_barang[0]->id])->inRandomOrder()->limit(8)->get();

        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
            $data_barang_wishlist = DB::Table('wishlist')->where('barang_id', '=', $id)->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain, 'total_cart' => $total_cart, 'data_barang_wishlist' => $data_barang_wishlist]);
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

        return view('pelanggan.shop.shop_by_type', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang]);
    }

    public function searchBarang(Request $request)
    {
        $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id','=','jenis_barang.id')->join('merek_barang', 'barang.merek_id','=','merek_barang.id')->where('nama', 'like', '%'.strtolower($request->key).'%')->paginate(15);

        $data_merek = null;

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();

        if(count($data_barang) > 0)
        {
            $data_merek = DB::table('merek_barang')->select('merek_barang.*')->join('barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.nama', 'like', '%'.strtolower($request->key).'%')->distinct()->get();   
        }

        if(Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'barang' => $data_barang, 'barang_search' => $data_barang_search, 'total_cart' => $total_cart]);
        }
        else
        {
            return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'barang' => $data_barang, 'barang_search' => $data_barang_search]);
        }

    }
}
