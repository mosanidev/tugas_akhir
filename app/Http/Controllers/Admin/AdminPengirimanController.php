<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengiriman = DB::table('detail_penjualan')
                        ->select('detail_penjualan.*', 'penjualan.*', 'pengiriman.*', 'alamat_pengiriman.*')
                        ->whereNotNull('detail_penjualan.pengiriman_id')
                        ->whereNotNull('detail_penjualan.alamat_pengiriman_id')
                        ->where('penjualan.status', '=', 'Pesanan sudah dibayar dan sedang disiapkan')
                        ->whereRaw("penjualan.metode_transaksi is not 'Ambil di toko'")
                        ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
                        ->join('pengiriman', 'detail_penjualan.pengiriman_id', '=', 'pengiriman.id')
                        ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')
                        ->get();

        return view('admin.pengiriman.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
