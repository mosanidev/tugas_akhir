<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

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
        $rules = [
            'nomor_nota' => 'unique:pembelian'
        ];
  
        $messages = [
            'nomor_nota.unique'=> 'Nomor Nota sudah ada'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        // $pembelian_id = DB::table('pembelian')->insertGetId(['nomor_nota'=>$request->nomor_nota, 'tanggal'=>$request->tanggal, 'supplier_id'=>$request->supplier_id]);
        $pembelian = DB::table('pembelian')->insert(['nomor_nota'=>$request->nomor_nota, 'tanggal'=>$request->tanggalBuat, 'tanggal_jatuh_tempo' => $request->tanggalJatuhTempo, 'supplier_id'=>$request->supplier_id]);

        return redirect()->route('pembelian.show', ['pembelian'=>$pembelian])->with(['success'=>'Tambah data pembelian berhasil. Silahkan tambahkan barang yang dibeli']);
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
        $barang = DB::table('barang')->get();

        if($request->ajax())
        {
            return response()->json(['pembelian'=>$pembelian]);
        }
        else 
        {
            return view('admin.pembelian.barang_dibeli.index', ['pembelian'=>$pembelian, 'barang'=>$barang]);
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
        $update = DB::table('pembelian')->where('id', $id)->update(['nomor_nota' => $request->nomor_nota, 'tanggal'=>$request->tanggal, 'supplier_id'=>$request->supplier_id]);
        
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
