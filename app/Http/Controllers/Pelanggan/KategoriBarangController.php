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
        $data_kategori = DB::table('barang')->select('barang.kategori_id', 'kategori_barang.kategori_barang')->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')->where('barang.jenis_id', '=', $id)->distinct()->get();

        $data_barang = DB::table('barang')->where('jenis_id', '=', $id)->inRandomOrder()->get();

        return view('pelanggan.shop.shop_by_category', ['kategori_barang' => $data_kategori, 'barang' => $data_barang]);
    }
}
