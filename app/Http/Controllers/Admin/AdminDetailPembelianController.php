<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminDetailPembelianController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        $insert = DB::table('detail_pembelian')->insert(['pembelian_id'=>$request->pembelian_id, 'barang_id'=>$request->barang_id, 'kuantitas'=>$request->kuantitas, 'subtotal'=>$request->subtotal]);

        $updateBarang = DB::table('barang')->where('id', $request->barang_id)->increment('jumlah_stok', $request->kuantitas); // tambahkan jumlah stok

        return redirect()->back()->with(['success' => 'Berhasil tambah data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang_id = explode("-", $id)[0];
        $pembelian_id = explode("-", $id)[1];

        $detailPembelian = DB::table('detail_pembelian')->select('detail_pembelian.*', 'barang.nama as nama_barang')->join('barang', 'barang.id', '=', 'detail_pembelian.barang_id')->where('barang_id', '=', $barang_id)->where('pembelian_id', '=', $pembelian_id)->get();

        return response()->json($detailPembelian);
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
    public function destroy(Request $request, $id)
    {
        $pembelian_id = $id;
        $barang_id = $request->barang_id;
        $qty = $request->kuantitas;

        $delete = DB::table('detail_pembelian')->where('pembelian_id', '=', $pembelian_id)->where('barang_id', '=', $barang_id)->delete();

        $updateBarang = DB::table('barang')->where('id', '=', $barang_id)->decrement('jumlah_stok', $qty);

        return redirect()->route('pembelian.show', ['pembelian'=>$pembelian_id])->with(['success' => 'Data berhasil dihapus']);
    }
}
