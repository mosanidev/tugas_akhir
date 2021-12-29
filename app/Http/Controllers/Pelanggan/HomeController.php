<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function showHome()
    {
        $curDate = \Carbon\Carbon::now()->format("Y-m-d");

        $barang = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->where('tanggal_kadaluarsa', '<' , $curDate)->inRandomOrder()->limit(16)->get(); // yang penjualannya paling banyak harusnya       
        $barang_promo = DB::table('barang')->select('barang.*')->where('barang.jumlah_stok', '>', 0)->where('barang.tanggal_kadaluarsa', '>', $curDate)->where('barang.diskon_potongan_harga', '>', 0)->where('periode_diskon.status', '=', 'Aktif')->where('periode_diskon.tanggal_dimulai', '<=', $curDate)->where('periode_diskon.tanggal_berakhir', '>=', $curDate)->join('periode_diskon', 'barang.periode_diskon_id','=','periode_diskon.id')->inRandomOrder()->limit(8)->get(); // yang penjualannya paling banyak harusnya

        $kategori = DB::table('kategori_barang')->get();

        $data_cart = array();

        $notifikasi = null;

        $files = Storage::disk('public')->allFiles("images/banner");

        if (Auth::check())
        {
            $notifikasi = DB::table('wishlist')->select('wishlist.barang_id', 'wishlist.harga_barang', 'barang.nama')->join('barang', 'wishlist.barang_id', '=', 'barang.id')->where('wishlist.users_id', '=', auth()->user()->id)->where('barang.harga_jual', '<', 'wishlist.harga_barang')->get();
            $data_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        return view('pelanggan.home', ['barang' => $barang, 'semua_kategori' => $kategori, 'barang_promo' => $barang_promo, 'total_cart' => $data_cart, 'files' => $files, 'notifikasi' => $notifikasi]);
    }
}
