<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = DB::table('penjualan')
                        ->select('penjualan.*', 'detail_penjualan.*', 'pembayaran.*', 'users.*')
                        ->where('penjualan.jenis', '=', 'Online')
                        ->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                        ->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')
                        ->join('users', 'penjualan.users_id', '=', 'users.id')
                        ->groupBy('penjualan.id')
                        ->orderByDesc('penjualan.created_at')
                        ->get();

        return view('admin.penjualan.index', ['penjualan'=>$penjualan]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $penjualan = DB::table('penjualan')
                        ->select('penjualan.*', 'pembayaran.*', 'users.*')
                        ->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')
                        ->join('users', 'penjualan.users_id', '=', 'users.id')
                        ->where('penjualan.id', '=', $id)
                        ->groupBy('penjualan.id')->get();

        $detail_penjualan = DB::table('detail_penjualan')
                                ->select('detail_penjualan.*', 'barang.*')
                                ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                                ->where('detail_penjualan.penjualan_id', '=', $id)->get();
    
        if($request->ajax())
        {
            return response()->json(['penjualan' => $penjualan, 'detail_penjualan' => $detail_penjualan]);
        }
        else 
        {
            return view('admin.penjualan.lihat', ['penjualan'=>$penjualan, 'detail_penjualan'=>$detail_penjualan]);
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
