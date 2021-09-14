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
        $data_merek = DB::table('barang')->select('barang.merek_id', 'merek_barang.merek_barang')->join('merek_barang', 'merek_barang.id', '=', 'barang.merek_id')->where('barang.kategori_id', '=', $id)->distinct()->get();
        $data_barang = DB::table('barang')->where('kategori_id', '=', $id)->get();

        return view('pelanggan.shop.shop_by_brand', ['merek_barang' => $data_merek, 'barang' => $data_barang, 'id' => $id]);
    }
}
