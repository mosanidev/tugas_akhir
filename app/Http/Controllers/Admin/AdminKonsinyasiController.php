<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminKonsinyasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konsinyasi = DB::table('konsinyasi')->select('konsinyasi.*', 'supplier.nama as nama_supplier')->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')->get();
        $supplier = DB::table('supplier')->get();

        return view('admin.konsinyasi.index', ['konsinyasi' => $konsinyasi, 'supplier' => $supplier]);
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
        $insert = DB::table('konsinyasi')->insert(['nomor_nota' => $request->nomor_nota, 'tanggal_titip' => $request->tanggal_titip, 'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo, 'supplier_id' => $request->supplier_id, 'metode_pembayaran' => $request->metode_pembayaran, 'status' => $request->status]);

        if($insert)
        {
            return redirect()->back()->with(['success' => 'Data berhasil ditambah']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $konsinyasi = DB::table('konsinyasi')->where('id', '=', $id)->get();

        return response()->json($konsinyasi);
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
