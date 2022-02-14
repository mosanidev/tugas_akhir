<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = DB::table('supplier')->get();

        return view('admin.supplier.index', ['supplier' => $supplier]);
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
        $rules = [
            'nomor_telepon' => 'unique:supplier'
        ];
  
        $messages = [
            'nomor_telepon.unique'=> 'Sudah ada nomor telepon barang yang sama'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $insert = DB::table('supplier')->insert([
            'nama' => $request->nama, 
            'jenis' => $request->jenis, 
            'alamat' => $request->alamat, 
            'nomor_telepon' => $request->nomor_telepon
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambah');
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
        $supplier = DB::table('supplier')->select('*')->where('id', '=', $id)->get();
        
        return response()->json(['supplier'=>$supplier[0]]);
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
        dd($request);
        $update = DB::table('supplier')->where('id', '=', $id)->update([
                                            'nama'=>$request->nama, 
                                            'alamat'=>$request->alamat, 
                                            'nomor_telepon'=>$request->nomor_telepon,
                                            'jenis' => $request->jenis
                                        ]);

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
        $delete = DB::table('supplier')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
