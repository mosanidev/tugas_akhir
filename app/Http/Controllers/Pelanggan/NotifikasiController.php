<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotifikasiController extends Controller
{
    public function index()
    {
        $selisih = DB::select('SELECT wishlist.*, barang.* FROM barang inner join wishlist on barang.id=wishlist.barang_id where (barang.harga_jual-barang.diskon_potongan_harga) < wishlist.harga_barang and wishlist.users_id = ?', [auth()->user()->id]);
        $kategori = DB::table('kategori_barang')->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['notifikasi' => $selisih, 'semua_kategori' => $kategori, 'total_cart' => $total_cart]);
    }
}
