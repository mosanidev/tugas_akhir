<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminKategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = DB::table('kategori_barang')->get();

        return view('admin.kategori_barang.index', ['kategori_barang' => $kategori]);
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
        try {

            $insert = DB::table('kategori_barang')->insert([
                'kategori_barang' => $request->kategori_barang
            ]);

            return redirect()->back();

        }
        catch(\Illuminate\Database\QueryException $ex){ 
            dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
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
        $kategori = DB::table('kategori_barang')->select('*')->where('id', '=', $id)->get();
        
        return response()->json(['kategori'=>$kategori[0]]);
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
        $update = DB::table('kategori_barang')->where('id', $id)
                                ->update(['kategori_barang' => $request->kategori_barang]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $delete_kategori = DB::table('kategori_barang')->where('id', '=', $id)->delete();

            $delete_barang = DB::table('barang')->where('kategori_id', '=', $id)->delete();

            return redirect()->back();
            
        }
        catch(\Illuminate\Database\QueryException $ex){ 
            dd($ex->getMessage()); 
            // Note any method of class PDOException can be called on $ex.
        }
    }

    public function search(Request $request)
    {   
        $result = DB::table('kategori_barang')->select('*')->where('kategori_barang', 'like', '%'.$request->kategori.'%')->limit(5)->get();

        return response()->json(['kategori'=>$result]);  
    }
}
