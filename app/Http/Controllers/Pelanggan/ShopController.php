<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ShopController extends Controller
{
    public function index()
    {
        $data_jenis = DB::table('jenis_barang')->get();
        $data_barang = DB::table('barang')->get();

        return view('pelanggan.shop.shop_by_jenis', ['jenis_barang' => $data_jenis, 'barang' => $data_barang]);
    }

    
}
