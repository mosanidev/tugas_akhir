<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retur_penjualan = DB::table('retur_penjualan')
                            ->select('retur_penjualan.id',
                                     'penjualan.nomor_nota', 
                                     'users.nama_depan', 
                                     'users.nama_belakang', 
                                     'penjualan.tanggal as tanggal_jual',
                                     'retur_penjualan.tanggal as tanggal_retur',
                                     'retur_penjualan.status')
                            ->join('penjualan', 'penjualan.id', '=', 'retur_penjualan.penjualan_id')
                            ->join('users', 'retur_penjualan.users_id', '=', 'users.id')
                            ->get();

        return view('admin.retur_penjualan.index', ['retur_penjualan' => $retur_penjualan]);
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
        $updateStatus = DB::table('retur_penjualan')
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $request->status_retur
                        ]);

        return redirect()->route('retur_penjualan.index')->with(['success' => 'Data berhasil diubah']);
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
