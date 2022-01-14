<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select pembelian yang datanya tidak ada di retur pembelian
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.id', 'pembelian.nomor_nota', 'pembelian.tanggal', 'pembelian.supplier_id', 'supplier.nama as nama_supplier')
                        ->leftJoin('retur_pembelian', 'retur_pembelian.pembelian_id', '=', 'pembelian.id')
                        ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                        ->where('retur_pembelian.pembelian_id', '=', null)
                        ->get();

        $retur_pembelian = DB::table('retur_pembelian')->select('pembelian.nomor_nota', 'retur_pembelian.*', 'supplier.nama as nama_supplier', 'users.nama_depan as nama_depan_pembuat', 'users.nama_belakang as nama_belakang_pembuat')
                            ->join('pembelian', 'retur_pembelian.pembelian_id', '=', 'pembelian.id')
                            ->join('users', 'users.id', '=', 'retur_pembelian.users_id')
                            ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                            ->get();

        return view('admin.retur_pembelian.index', ['pembelian' => $pembelian, 'retur_pembelian'=>$retur_pembelian]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $retur_pembelian = DB::table('retur_pembelian')->select('pembelian_id')->pluck('pembelian_id')->toArray();
        $pembelian = DB::table('pembelian') ->whereNotIn('id', [$retur_pembelian])->get();
        $detail_pembelian = DB::table('detail_pembelian')->whereNotIn('pembelian_id', [$retur_pembelian])->get();

        return view('admin.retur_pembelian.tambah', ['pembelian'=>$pembelian, 'detail_pembelian'=>$detail_pembelian]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $insert = DB::table('')
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

    public function loadBarangRetur($id)
    {
        $barang_retur = DB::table('barang')->select('barang.id', 'barang.nama')->join('detail_pembelian', 'barang.id', '=', 'detail_pembelian.barang_id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

        return response()->json(['barang_retur'=>$barang_retur]);
    }

    public function loadInfoBarangRetur($id)
    {
        $barang_retur = DB::table('barang')->select('detail_pembelian.kuantitas', 'detail_pembelian.harga_beli')->join('detail_pembelian', 'barang.id', '=', 'detail_pembelian.barang_id')->where('barang.id', '=', $id)->get();

        return response()->json(['barang_retur'=>$barang_retur]);
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
