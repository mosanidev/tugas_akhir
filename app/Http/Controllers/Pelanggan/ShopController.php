<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class ShopController extends Controller
{
    public function index()
    {
        $data_jenis = DB::table('jenis_barang')->get();
        $data_barang = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        return view('pelanggan.shop.shop_by_jenis', ['jenis_barang' => $data_jenis, 'barang' => $data_barang, 'total_cart'=>$total_cart]);
    }

    public function urutkanMerek(Request $request, $id)
    {
        $data_merek = DB::table('barang')->select('merek_barang.id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $id)->distinct()->get();

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();      

        if($request->selectUrutkan == "a-z")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('barang.kategori_id', '=', $id)->orderBy('nama', 'asc')->paginate(15);
        }
        else if($request->selectUrutkan == "z-a")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('barang.kategori_id', '=', $id)->orderBy('nama', 'desc')->paginate(15);
        }
        else if($request->selectUrutkan == "maxharga")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('barang.kategori_id', '=', $id)->orderByRaw('(harga_jual - diskon_potongan_harga) desc')->paginate(15);
        }
        else if($request->selectUrutkan == "minharga")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('barang.kategori_id', '=', $id)->orderByRaw('(harga_jual - diskon_potongan_harga) asc')->paginate(15);
        } 

        $kategori_id = $data_barang[0]->kategori_id;

        $data_barang->setPath("/id/brand/$kategori_id/urutkan?jenisFilter=$request->jenisFilter&filterUrutkan=$request->filterUrutkan&selectUrutkan=$request->selectUrutkan");
        return view('pelanggan.shop.shop_by_brand', ['barang' => $data_barang, 'merek_barang' => $data_merek, 'barang_search' => $data_barang_search]);
    }

    public function urutkanKategori(Request $request, $id)
    {
        $data_barang = null;

        // $data_jenis = DB::table('jenis_barang')->get();

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();      
    
        $total_cart = null;

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        $data_kategori = DB::table('barang')->select('barang.kategori_id', 'kategori_barang.kategori_barang')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->join('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_id')->where('barang.jenis_id', '=', $id)->distinct()->get();

        if($request->selectUrutkan == "a-z")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->where('barang.jenis_id', '=', $id)->orderBy('nama', 'asc')->paginate(15);
        }
        else if($request->selectUrutkan == "z-a")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->where('barang.jenis_id', '=', $id)->orderBy('nama', 'desc')->paginate(15);
        }
        else if($request->selectUrutkan == "maxharga")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->where('barang.jenis_id', '=', $id)->orderByRaw('(harga_jual - diskon_potongan_harga) desc')->paginate(15);
        }
        else if($request->selectUrutkan == "minharga")
        {
            $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis')->where('barang.jumlah_stok', '>', 0)->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->where('barang.jenis_id', '=', $id)->orderByRaw('(harga_jual - diskon_potongan_harga) asc')->paginate(15);
        } 

        $jenis_id = $data_barang[0]->jenis_id;

        $data_barang->setPath("/id/category/$jenis_id/urutkan?jenisFilter=$request->jenisFilter&filterUrutkan=$request->filterUrutkan&selectUrutkan=$request->selectUrutkan");
        return view('pelanggan.shop.shop_by_category', ['kategori_barang' => $data_kategori, 'barang' => $data_barang, 'barang_search' => $data_barang_search]);

    }

    public function urutkan(Request $request)
    {
        $data_barang = null;

        $data_jenis = DB::table('jenis_barang')->get();

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();      
    
        $total_cart = null;

        if (Auth::check())
        {
            $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('cart.users_id', '=', auth()->user()->id)->get();
        }

        if($request->selectUrutkan == "a-z")
        {
            $data_barang = DB::table('barang')->where('barang.jumlah_stok', '>', 0)->orderBy('nama', 'asc')->paginate(15);
        }
        else if($request->selectUrutkan == "z-a")
        {
            $data_barang = DB::table('barang')->where('barang.jumlah_stok', '>', 0)->orderBy('nama', 'desc')->paginate(15);
        }
        else if($request->selectUrutkan == "maxharga")
        {
            $data_barang = DB::table('barang')->where('barang.jumlah_stok', '>', 0)->orderByRaw('(harga_jual - diskon_potongan_harga) desc')->paginate(15);
        }
        else if($request->selectUrutkan == "minharga")
        {
            $data_barang = DB::table('barang')->where('barang.jumlah_stok', '>', 0)->orderByRaw('(harga_jual - diskon_potongan_harga) asc')->paginate(15);
        }   

        $data_barang->setPath("/shop/urutkan?jenisFilter=$request->jenisFilter&filterUrutkan=$request->filterUrutkan&selectUrutkan=$request->selectUrutkan");
        
        return view('pelanggan.shop.shop_by_type', ['jenis_barang' => $data_jenis, 'barang' => $data_barang, 'barang_search'=>$data_barang_search, 'total_cart'=>$total_cart]); 

    }
}
