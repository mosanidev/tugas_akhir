<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminDetailReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function storeReturDana(Request $request)
    {
        $barangRetur = json_decode($request->barangRetur, true);

        $updateTotalRetur = DB::table('retur_pembelian')
                                ->where('id', '=', $request->retur_pembelian_id)
                                ->update([
                                    'total' => $request->total 
                                ]);

        for($i = 0; $i < count((array) $barangRetur); $i++)
        {
            $insertDetailRetur = DB::table('detail_retur_pembelian')
                                    ->insert([
                                        'retur_pembelian_id' => $request->retur_pembelian_id,
                                        'barang_retur' => $barangRetur[$i]['barang_id'],
                                        'tanggal_kadaluarsa_barang_retur' => $barangRetur[$i]['barang_tanggal_kadaluarsa'],
                                        'kuantitas_barang_retur' => $barangRetur[$i]['jumlah_retur'],
                                        'keterangan' => $barangRetur[$i]['keterangan'],
                                        'subtotal' => $barangRetur[$i]['subtotal']
                                    ]);
        }

        $updatePembelian = DB::table('pembelian')
                            ->where('id', '=', $request->pembelian_id)
                            ->update([
                                'status_retur' => 'Ada Retur'
                            ]);

        return redirect()->route('retur_pembelian.index')->with(['success' => 'Data berhasil ditambah']);

    }

    public function storeTukarBarang(Request $request)
    {
        $tukarBarang = json_decode($request->tukarBarang, true);

        for($i = 0; $i < count((array) $tukarBarang); $i++)
        {
            $insertDetailRetur = DB::table('detail_retur_pembelian')
                                    ->insert([
                                        'retur_pembelian_id' => $request->retur_pembelian_id,
                                        'barang_retur' => $tukarBarang[$i]['barang_asal_id'],
                                        'tanggal_kadaluarsa_barang_retur' => $tukarBarang[$i]['tanggal_kadaluarsa_asal'],
                                        'kuantitas_barang_retur' => $tukarBarang[$i]['kuantitas_barang_asal'],
                                        'barang_ganti' => $tukarBarang[$i]['barang_ganti_id'],
                                        'tanggal_kadaluarsa_barang_ganti' => $tukarBarang[$i]['tanggal_kadaluarsa_ganti'],
                                        'kuantitas_barang_ganti' => $tukarBarang[$i]['kuantitas_barang_ganti'],
                                        'keterangan' => $tukarBarang[$i]['keterangan'],
                                        'subtotal' => null
                                    ]);
        }

        return redirect()->route('retur_pembelian.index')->with(['success' => 'Data berhasil ditambah']);
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
