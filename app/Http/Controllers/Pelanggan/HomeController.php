<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        $data_barang_promo = DB::table('barang')->select('*')->where('diskon_potongan_harga', '>', 0)->where('jumlah_stok', '>', 0)->inRandomOrder()->limit(8)->get();
        $data_barang = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();
        $data_cart = array();
        if (Auth::check())
        {
            $data_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        return view('pelanggan.home', ['data_barang_promo' => $data_barang_promo, 'barang' => $data_barang, 'total_cart' => $data_cart]);
    }
}
