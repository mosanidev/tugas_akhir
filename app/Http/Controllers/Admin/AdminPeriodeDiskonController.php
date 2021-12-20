<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPeriodeDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode_diskon = DB::table('periode_diskon')->get();

        return view('admin.periode_diskon.index', ['periode_diskon' => $periode_diskon]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periode_diskon = DB::table('periode_diskon')->get();
        $barangDiskon = DB::table('barang')->limit(15)->get();
        
        return view('admin.periode_diskon.tambah', ['periode_diskon' => $periode_diskon, 'barangDiskon' => $barangDiskon]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = DB::table('periode_diskon')->insertGetId(['nama'=>$request->nama, 'tanggal_dimulai'=>$request->tanggal_dimulai, 'tanggal_berakhir'=>$request->tanggal_berakhir]);

        return redirect()->route('periode_diskon.show', ['periode_diskon'=>$id])->with(['status'=>'Berhasil tambah data, Silahkan tambah data barang diskon']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periode_diskon = DB::table('periode_diskon')->where('id', '=', $id)->get();
        $barang = DB::table('barang')->where('periode_diskon_id', '=', $id)->get();
        $barang_diskon = DB::table('barang')->where('periode_diskon_id', '=', null)->get();


        return view('admin.periode_diskon.detail', ['periode_diskon' => $periode_diskon, 'barang' => $barang, 'barang_diskon'=>$barang_diskon ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode_diskon = DB::table('periode_diskon')->where('id', '=', $id)->get();

        return response()->json(['periode_diskon'=>$periode_diskon]);
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
        $update = DB::table('periode_diskon')->where('id', '=', $id)->update(['nama'=>$request->nama, 'tanggal_dimulai'=>$request->tanggal_dimulai, 'tanggal_berakhir'=>$request->tanggal_berakhir, 'status' => $request->status]);

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
        $ubah_barang = DB::table('barang')->where('periode_diskon_id', '=', $id)->update(['diskon_potongan_harga' => 0, 'periode_diskon_id' => null]);

        $delete = DB::table('periode_diskon')->where('id','=',$id)->delete();

        return redirect()->back()->with(['status'=>'Berhasil hapus data']);
    }

}
