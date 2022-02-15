<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminBarangDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = DB::table('barang')->where('periode_diskon_id', '=', null)->get();

        return response()->json(['barang' => $barang]);
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
        $insert = DB::table('barang')->where('id', '=', $request->barang_id)->update(['periode_diskon_id'=>$request->periode_diskon_id, 'diskon_potongan_harga'=>$request->potongan_harga]);

        return redirect()->back()->with(['status' => 'Berhasil tambah data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = DB::table('barang')->select('id', 'nama', 'harga_jual', 'diskon_potongan_harga')->where('periode_diskon_id', '=', null)->orWhere('id', '=', $id)->get();
       
        return response()->json(['barang'=>$barang]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = DB::table('barang')->select('id', 'nama', 'harga_jual', 'diskon_potongan_harga')->where('periode_diskon_id', '=', null)->orWhere('id', '=', $id)->get();
       
        return response()->json(['barang'=>$barang]);
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
        if($request->barang_id != $id)
        {
            $update_1 = DB::table('barang')->where('id', '=', $id)->update(['diskon_potongan_harga'=>0, 'periode_diskon_id'=>null]);

            $update_2 = DB::table('barang')->where('id', '=', $request->barang_id)->update(['diskon_potongan_harga'=>$request->potongan_harga, 'periode_diskon_id'=>$request->periode_diskon_id]);

        }
        else
        {
            $update = DB::table('barang')->where('id', '=', $id)->update(['diskon_potongan_harga'=>$request->potongan_harga]);

        }

        return redirect()->back()->with(['status' => 'Berhasil ubah data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = DB::table('barang')->where('id','=',$id)->update(['diskon_potongan_harga'=>0, 'periode_diskon_id'=>null]);
        
        return redirect()->back()->with(['status' => 'Berhasil hapus data']);
    }

    public function load(Request $request)
    {
        if(isset($request->periode_diskon_id))
        {
            $barang = DB::table('barang')
                        ->where('periode_diskon_id', '=', null)
                        ->orWhere('periode_diskon_id', '=', $request->periode_diskon_id)
                        ->get();
        }
        else 
        {
            $barang = DB::table('barang')
                        ->where('periode_diskon_id', '=', null)
                        ->get();

        }

        return response()->json(['barang' => $barang]);
    }
}
