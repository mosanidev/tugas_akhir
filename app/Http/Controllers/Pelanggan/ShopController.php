<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class ShopController extends Controller
{
    public function filterSearchOrder(Request $request)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_kategori = DB::table('kategori_barang')->get();

        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('nama', 'like', '%'.strtolower($request->key).'%')
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                        ->where('kategori_barang.kategori_barang', '=', $request->input_kategori)
                        ->groupBy('barang.id');

        $data_merek = DB::table('barang')
                        ->select('merek_barang.id', 'merek_barang.merek_barang')
                        ->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')
                        ->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')
                        ->where('kategori_barang.kategori_barang', '=', $request->input_kategori)->distinct()->get();

        // check filter
        if ($request->merek == null && $request->hargamin == null && $request->hargamax == null)
        {
            $data_barang = $data_barang;
        }
        else if ($request->merek == null)
        {
            $data_barang = $data_barang->whereRaw('barang.harga_jual-barang.diskon_potongan_harga BETWEEN ? AND ?', [$request->hargamin, $request->hargamax])->where('barang.kategori_id', '=', $request->kategori_id);
        } 
        else if ($request->hargamin == null || $request->hargamax == null)
        {
            $data_barang = $data_barang->whereIn('merek_id', $request->merek)->where('barang.kategori_id', '=', $request->kategori_id);
        }
        else 
        {
            $data_barang = $data_barang->whereIn('merek_id', $request->merek)->whereRaw('barang.harga_jual-barang.diskon_potongan_harga BETWEEN ? AND ?', [$request->hargamin, $request->hargamax])->where('barang.kategori_id', '=', $request->kategori_id);
        }

        //check urutkan
        if($request->urutkan == "random")
        {
            $data_barang = $data_barang->inRandomOrder();
        }
        else if($request->urutkan == "a-z")
        {
            $data_barang = $data_barang->orderBy('nama', 'asc');
        }
        else if($request->urutkan == "z-a")
        {
            $data_barang = $data_barang->orderBy('nama', 'desc');
        }
        else if($request->urutkan == "maxharga")
        {
            $data_barang = $data_barang->orderByRaw('(harga_jual - diskon_potongan_harga) desc');
        }
        else if($request->urutkan == "minharga")
        {
            $data_barang = $data_barang->orderByRaw('(harga_jual - diskon_potongan_harga) asc');
        } 

        $data_barang = $data_barang->paginate(15);

        $data_barang->setPath("/search/filter&order?key=$request->key&input_kategori=$request->input_kategori&kategori_id=$request->kategori_id&hargamin=$request->hargamin&hargamax=$request->hargamax&urutkan=$request->urutkan");

        return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'id' => $request->kategori_id, 'merek_checked' => $request->merek, 'hargamin' => $request->hargamin, 'hargamax' => $request->hargamax]);    

    }
    
    public function filterOrder(Request $request, $id)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_kategori = DB::table('kategori_barang')->get();

        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->where('barang.kategori_id', '=', $id)
                        ->groupBy('barang.id');

        $data_merek = DB::table('barang')->select('merek_barang.id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $request->kategori_id)->distinct()->get();

        // check filter
        if ($request->merek == null && $request->hargamin == null && $request->hargamax == null)
        {
            $data_barang = $data_barang;
        }
        else if ($request->merek == null)
        {
            $data_barang = $data_barang->whereRaw('barang.harga_jual-barang.diskon_potongan_harga BETWEEN ? AND ?', [$request->hargamin, $request->hargamax])->where('barang.kategori_id', '=', $request->kategori_id);
        } 
        else if ($request->hargamin == null || $request->hargamax == null)
        {
            $data_barang = $data_barang->whereIn('merek_id', $request->merek)->where('barang.kategori_id', '=', $request->kategori_id);
        } 
        else 
        {
            $data_barang = $data_barang->whereIn('merek_id', $request->merek)->whereRaw('barang.harga_jual-barang.diskon_potongan_harga BETWEEN ? AND ?', [$request->hargamin, $request->hargamax])->where('barang.kategori_id', '=', $request->kategori_id);
        }

        //check urutkan
        if($request->urutkan == "random")
        {
            $data_barang = $data_barang->inRandomOrder();
        }
        else if($request->urutkan == "a-z")
        {
            $data_barang = $data_barang->orderBy('nama', 'asc');
        }
        else if($request->urutkan == "z-a")
        {
            $data_barang = $data_barang->orderBy('nama', 'desc');
        }
        else if($request->urutkan == "maxharga")
        {
            $data_barang = $data_barang->orderByRaw('(harga_jual - diskon_potongan_harga) desc');
        }
        else if($request->urutkan == "minharga")
        {
            $data_barang = $data_barang->orderByRaw('(harga_jual - diskon_potongan_harga) asc');
        } 

        $data_barang = $data_barang->paginate(15);

        $data_barang->setPath("/id/category/$id/order?urutkan=$request->urutkan");

        return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'id' => $request->kategori_id, 'merek_checked' => $request->merek, 'hargamin' => $request->hargamin, 'hargamax' => $request->hargamax]);    

    }

    public function orderProductsByType(Request $request, $id)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_barang = null;

        $data_jenis_dipilih = DB::table('jenis_barang')->where('id', '=', $id)->get();

        $data_semua_kategori = DB::table('kategori_barang')->get();
    
        $total_cart = null;

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        $data_kategori = DB::table('barang')->select('barang.kategori_id', 'kategori_barang.kategori_barang')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->join('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_id')->where('barang.jenis_id', '=', $id)->distinct()->get();

        if($request->urutkan == "random")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                            ->inRandomOrder()
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "a-z")
        {
            $data_barang = DB::table('barang')
                                ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis')
                                ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                                ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                                ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                                ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                                ->where('barang.jenis_id', '=', $id)
                                ->orderBy('nama', 'asc')
                                ->groupBy('barang.id')
                                ->paginate(15);
        }
        else if($request->urutkan == "z-a")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis')
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                            ->where('barang.jenis_id', '=', $id)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                            ->orderBy('nama', 'desc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "maxharga")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis')
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                            ->where('barang.jenis_id', '=', $id)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                            ->orderByRaw('(harga_jual - diskon_potongan_harga) desc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "minharga")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'jenis_barang.jenis_barang as nama_jenis')
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                            ->where('barang.jenis_id', '=', $id)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>' , $oneWeekLater)
                            ->orderByRaw('(harga_jual - diskon_potongan_harga) asc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }

        $data_barang->setPath("/id/type/$id/order?urutkan=$request->urutkan");
        
        return view('pelanggan.shop.shop_by_category', ['semua_kategori' => $data_semua_kategori, 'jenis_dipilih' => $data_jenis_dipilih, 'kategori' => $data_kategori, 'barang' => $data_barang]);

    }

    public function showRandom()
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_jenis = DB::table('jenis_barang')->get();

        $data_kategori = DB::table('kategori_barang')->get();
    
        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->inRandomOrder()
                        ->groupBy('barang.id')
                        ->paginate(15);                  

        $total_cart = null;

        if (Auth::check())
        {
            $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
            $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'total_cart'=>$total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]); 
        }
        else 
        {
            return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'total_cart'=>$total_cart]); 

        }

    }

    public function showProductsBasedOnType($id)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_semua_kategori = DB::table('kategori_barang')->get();
        $data_kategori = DB::table('barang')->select('barang.kategori_id', 'kategori_barang.kategori_barang')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->join('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_id')->where('barang.jenis_id', '=', $id)->distinct()->get();
        $data_jenis_dipilih = DB::table('jenis_barang')->where('id', '=', $id)->get();
        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->where('jenis_id', '=', $id)
                        ->inRandomOrder()
                        ->groupBy('barang.id')
                        ->paginate(15);

        if (Auth::check())
        {
            $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
            $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();

            return view('pelanggan.shop.shop_by_category', ['kategori' => $data_kategori, 'jenis_dipilih' => $data_jenis_dipilih, 'semua_kategori' => $data_semua_kategori, 'barang' => $data_barang, 'total_cart'=>$total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
        }
        else 
        {
            return view('pelanggan.shop.shop_by_category', ['kategori' => $data_kategori, 'jenis_dipilih' => $data_jenis_dipilih, 'semua_kategori' => $data_semua_kategori, 'barang' => $data_barang, 'total_cart'=>$total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);

        }
    }

    public function showProductsBasedOnCategory($id)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_kategori = DB::table('kategori_barang')->get();
        $data_barang = DB::table('barang')
                        ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'), 'barang.merek_id', 'barang.kategori_id', 'merek_barang.merek_barang as nama_merek', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')
                        ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                        ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->where('barang.kategori_id', '=', $id)
                        ->distinct()
                        ->groupBy('barang.id')
                        ->paginate(15);
        $data_jenis = DB::table('jenis_barang')->where('id', '=', $id);
        $data_merek = DB::table('barang')->select('merek_barang.id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $id)->distinct()->get();

        return view('pelanggan.shop.shop_by_brand', ['barang' => $data_barang, 'semua_kategori' => $data_kategori, 'merek_barang' => $data_merek]);
    }

    public function orderProducts(Request $request)
    {
        $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $data_barang = null;

        $data_kategori = DB::table('kategori_barang')->get();

        $data_jenis = DB::table('jenis_barang')->get();
    
        $total_cart = null;

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        if($request->urutkan == "random")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->inRandomOrder()
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "a-z")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->orderBy('nama', 'asc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "z-a")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->orderBy('nama', 'desc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "maxharga")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->orderByRaw('(harga_jual - diskon_potongan_harga) desc')
                            ->groupBy('barang.id')
                            ->paginate(15);
        }
        else if($request->urutkan == "minharga")
        {
            $data_barang = DB::table('barang')
                            ->select('barang.*', DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                            ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $oneWeekLater)
                            ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                            ->orderByRaw('(harga_jual - diskon_potongan_harga) asc')
                            ->groupBy('barang.id')
                            ->paginate(15);        
        }   

        $data_barang->setPath("/shop/order?urutkan=$request->urutkan");
        
        return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'semua_kategori' => $data_kategori, 'barang' => $data_barang, 'total_cart'=>$total_cart]); 

    }
}
