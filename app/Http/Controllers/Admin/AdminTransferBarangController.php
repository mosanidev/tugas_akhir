<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminTransferBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transferBarang = DB::table('transfer_barang')
                            ->select('transfer_barang.*', 'users.nama_depan', 'users.nama_belakang')
                            ->join('users', 'transfer_barang.users_id', '=', 'users.id')
                            ->get();

        return view('admin.transfer_barang.index', ['transfer_barang' => $transferBarang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nomorTransfer = DB::table('transfer_barang')
                            ->selectRaw('max(id) as nomor_transfer_barang')
                            ->get();

        $barang = DB::table('barang_has_kadaluarsa')
                    ->select('barang.id', 'barang.kode', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok')
                    ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                    ->get();

        $nomorTransfer = $nomorTransfer[0]->nomor_transfer_barang+1;

        return view('admin.transfer_barang.tambah', ['barang' => $barang, 'nomor_transfer_barang' => $nomorTransfer]);
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
