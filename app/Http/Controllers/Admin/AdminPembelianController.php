<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->get();
        $supplier = DB::table('supplier')->get();

        return view('admin.pembelian.index', ['pembelian'=>$pembelian, 'supplier'=>$supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = DB::table('supplier')->get();
        $barang = DB::table('barang')->get();

        return view('admin.pembelian.tambah', ['supplier'=>$supplier, 'barang'=>$barang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $konsinyasi = isset($request->konsinyasi) ? 1 : 0;

        $pembelian_id = DB::table('pembelian')->insertGetId(['nomor_nota'=>$request->nomor_nota, 'tanggal'=>$request->tanggal, 'supplier_id'=>$request->supplier_id, 'sistem_konsinyasi'=>$konsinyasi]);

        return redirect()->route('pembelian.show', ['pembelian'=>$pembelian_id])->with(['status'=>'Tambah data pembelian berhasil. Silahkan tambahkan barang yang dibeli']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->where('pembelian.id', '=', $id)->get();



        if($request->ajax())
        {
            return response()->json(['pembelian'=>$pembelian]);
        }
        else 
        {
            return view('admin.pembelian.barang_dibeli.index', ['pembelian'=>$pembelian]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = DB::table('supplier')->get();
        $barang = DB::table('barang')->get();
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->where('pembelian.id', '=', $id)->get();
        $detail_pembelian = DB::table('detail_pembelian')->select('detail_pembelian.*', 'barang.nama as nama_barang')->join('barang', 'detail_pembelian.barang_id', '=', 'barang.id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

        return view('admin.pembelian.ubah', ['pembelian'=>$pembelian, 'detail_pembelian'=>$detail_pembelian, 'supplier'=>$supplier, 'barang'=>$barang]);
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

        $konsinyasi = isset($request->konsinyasi) ? 1 : 0;

        $update = DB::table('pembelian')->update(['nomor_nota' => $request->nomor_nota, 'tanggal'=>$request->tanggal, 'supplier_id'=>$request->supplier_id, 'sistem_konsinyasi'=>$konsinyasi])->where('id', '=', $id);
        
        return redirect()->back()->with(['status'=>'Berhasil ubah data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('pembelian')->where('id', '=', $id)->delete();

        return redirect()->route('pembelian.index')->with(['status'=>'Hapus data berhasil']);

    }
}
