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
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $curDate = \Carbon\Carbon::now()->format("Y-m-d H:m:s");

        $barang_konsinyasi = DB::table('barang')
                    ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                    ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                    ->where('barang_konsinyasi', '=', 1)
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $curDate)
                    ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->inRandomOrder()->limit(16)->get(); 

        // 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok'
        // DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok')

        $barang_promo = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->where('barang.diskon_potongan_harga', '>', 0)
                            ->where('periode_diskon.tanggal_dimulai', '<=', $curDate)
                            ->where('periode_diskon.tanggal_berakhir', '>=', $curDate)
                            ->join('periode_diskon', 'barang.periode_diskon_id','=','periode_diskon.id')
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->inRandomOrder()->limit(8)->get(); // yang penjualannya paling banyak harusnya

        $kategori = DB::table('kategori_barang')->get();

        $data_cart = array();

        $notifikasi = null;

        $files = Storage::disk('public')->allFiles("images/banner");

        if (Auth::check())
        {
            $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
            $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();
            $data_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.home', ['barang_konsinyasi' => $barang_konsinyasi, 'semua_kategori' => $kategori, 'barang_promo' => $barang_promo, 'total_cart' => $data_cart, 'files' => $files, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
        }
        else 
        {
            return view('pelanggan.home', ['barang_konsinyasi' => $barang_konsinyasi, 'semua_kategori' => $kategori, 'barang_promo' => $barang_promo, 'total_cart' => $data_cart, 'files' => $files]);
        }
    }
}
