<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = DB::table('penjualan')->select('penjualan.*', 'detail_penjualan.*', 'pembayaran.*', 'users.*')->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')->join('users', 'penjualan.users_id', '=', 'users.id')->groupBY('penjualan.id')->orderByDesc('penjualan.created_at')->get();

        return view('admin.penjualan.index', ['penjualan'=>$penjualan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = DB::table('penjualan')->select('penjualan.*', 'pembayaran.*', 'users.*')->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')->join('users', 'penjualan.users_id', '=', 'users.id')->where('penjualan.nomor_nota', '=', $id)->groupBy('penjualan.nomor_nota')->get();

        $detail_penjualan = DB::table('detail_penjualan')->select('detail_penjualan.*', 'barang.*')->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')->where('detail_penjualan.nomor_nota', '=', $id)->get();
    
        return view('admin.penjualan.lihat', ['penjualan'=>$penjualan, 'detail_penjualan'=>$detail_penjualan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
