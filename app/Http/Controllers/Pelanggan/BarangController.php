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
        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->where('barang.id', '=', $id)
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbon\Carbon::now())
                        ->select('barang.*', 'kategori_barang.kategori_barang', 'jenis_barang.jenis_barang', 'merek_barang.merek_barang', DB::raw("sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok"))
                        ->get();

        $data_kategori = DB::table('kategori_barang')->get();

        $data_barang_lain = DB::table('barang')
                                ->select('barang.*', 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok')
                                ->where('barang.jenis_id', '=', $data_barang[0]->jenis_id)
                                ->whereNotIn('barang.id', [$data_barang[0]->id])
                                ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                                ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbon\Carbon::now())
                                ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                                ->whereNotIn('barang.id', [$id])
                                ->inRandomOrder()
                                ->limit(8)
                                ->get();

        $data_barang_serupa = DB::table('barang')
                            ->select('barang.*', 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok')
                            ->where('barang.kategori_id', '=', $data_barang[0]->kategori_id)
                            ->whereNotIn('barang.id', [$data_barang[0]->id])
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbon\Carbon::now())
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->whereNotIn('barang.id', [$id])
                            ->inRandomOrder()
                            ->limit(8)
                            ->get();

        if(Auth::check())
        {
            $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
            $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
            $data_barang_wishlist = DB::Table('wishlist')->where('barang_id', '=', $id)->where('users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'semua_kategori' => $data_kategori, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain, 'total_cart' => $total_cart, 'data_barang_wishlist' => $data_barang_wishlist, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
        }
        else
        {

            return view('pelanggan.product_detail', ['barang' => $data_barang, 'semua_kategori' => $data_kategori, 'barang_serupa' => $data_barang_serupa, 'barang_lain' => $data_barang_lain]);
        }
    }

    public function showPromo()
    {
        // $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_barang = DB::table('barang')
                        ->select('barang.*', 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok')
                        ->where('barang.diskon_potongan_harga', '>', 0)
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        // ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->inRandomOrder()
                        ->get();

        $data_jenis = DB::table('jenis_barang')->get();

        return view('pelanggan.shop.shop_by_type', ['state' => 'jenis', 'jenis_barang' => $data_jenis, 'barang' => $data_barang]);
    }

    public function searchBarang(Request $request)
    {
        $data_barang = DB::table('barang')
                        ->select('barang.*', 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori', 'merek_barang.merek_barang')
                        ->join('jenis_barang', 'barang.jenis_id','=','jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id','=','kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id','=','merek_barang.id')
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', \Carbpn\Carbon::now())
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->where('nama', 'like', '%'.strtolower($request->key).'%')
                        ->where('kategori_barang.kategori_barang', '=', $request->input_kategori)
                        ->groupBy('barang.id')
                        ->paginate(15);

        $data_merek = null;

        $data_kategori = DB::table('kategori_barang')->get();

        if(count($data_barang) > 0)
        {
            $data_merek =  DB::table('barang')
                            ->select('merek_barang.id', 'merek_barang.merek_barang')
                            ->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')
                            ->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')
                            ->where('kategori_barang.kategori_barang', '=', $request->input_kategori)
                            ->where('barang.nama', 'like', '%'.strtolower($request->key).'%')
                            ->distinct()
                            ->get(); 

            // $data_merek = DB::table('merek_barang')
            //                 ->select('merek_barang.*')
            //                 ->join('barang', 'merek_barang.id', '=', 'barang.merek_id')
            //                 ->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')
            //                 ->where('kategori_barang.kategori_barang', '=', $request->input_kategori)
            //                 ->distinct()
            //                 ->get();   
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
