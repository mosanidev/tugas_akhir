<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotifikasiController extends Controller
{
    public function index()
    {
        $ubahStatus = DB::table('notifikasi')->where('users_id', '=', auth()->user()->id)->update(['status' => 'Sudah dilihat']);

        $jumlahNotif = DB::table('notifikasi')->select(DB::raw('COUNT(*) as jumlah_notif'))->where('users_id', '=', auth()->user()->id)->get();

        $notifikasi = DB::table('notifikasi')
                        ->where('users_id', '=', auth()->user()->id)
                        ->orderBy('updated_at', 'desc')
                        ->get();

        $kategori = DB::table('kategori_barang')->get();

        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();

        $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['notifikasi' => $notifikasi, 'jumlah_notif' => $jumlahNotif, 'semua_kategori' => $kategori, 'total_cart' => $total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
    }
}
