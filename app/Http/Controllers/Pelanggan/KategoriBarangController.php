<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class KategoriBarangController extends Controller
{
    public function show($id)
    {
        // $data_kategori = DB::table('kategori_barang')->where('jenis_barang_id', '=', $id)->get();
        $data_kategori = DB::table('barang')->select('barang.kategori_id', 'kategori_barang.kategori_barang')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->join('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_id')->where('barang.jenis_id', '=', $id)->distinct()->get();
        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();
        $data_barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as nama_jenis')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->where('jenis_id', '=', $id)->inRandomOrder()->paginate(15);

        return view('pelanggan.shop.shop_by_category', ['kategori_barang' => $data_kategori, 'barang' => $data_barang, 'barang_search' => $data_barang_search]);
    }
}
