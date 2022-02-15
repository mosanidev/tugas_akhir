<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminJenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis = DB::table("jenis_barang")->get();

        return view('admin.jenis_barang.index', ['jenis_barang' => $jenis]);
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
        $insert = DB::table('jenis_barang')->insert([
            'jenis_barang' => $request->jenis_barang
        ]);

        return redirect()->back()->with(['success' => 'Data jenis berhasil bertambah']);
        
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
        $jenis = DB::table('jenis_barang')->select('*')->where('id', '=', $id)->get();
        
        return response()->json(['jenis'=>$jenis[0]]);
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
        $update = DB::table('jenis_barang')->where('id', $id)
                                ->update(['jenis_barang' => $request->jenis_barang]);

        return redirect()->back()->with(['success' => 'Data jenis berhasil berubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_jenis = DB::table('jenis_barang')->where('id', '=', $id)->delete();

        $delete_barang = DB::table('barang')->where('jenis_id', '=', $id)->delete();

        return redirect()->back()->with(['success' => 'Data jenis berhasil dihapus']);
       
    }

}
