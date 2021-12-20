<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Input;

class MerekBarangController extends Controller
{
    public function show($id)
    {
        $data_barang = DB::table('barang')->select('barang.*', 'barang.merek_id', 'barang.kategori_id', 'merek_barang.merek_barang as nama_merek', 'jenis_barang.jenis_barang as nama_jenis', 'kategori_barang.kategori_barang as nama_kategori')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->where('barang.kategori_id', '=', $id)->distinct()->paginate(15);
        $data_merek = DB::table('barang')->select('merek_barang.id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $id)->distinct()->get();

        $data_barang_search = DB::table('barang')->select('*')->where('jumlah_stok', '>', 0)->limit(5)->get();

        return view('pelanggan.shop.shop_by_brand', ['barang' => $data_barang, 'merek_barang' => $data_merek, 'barang_search' => $data_barang_search]);
    }
}
