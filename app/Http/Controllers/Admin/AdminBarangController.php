<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->get();

        return view('admin.barang.index', ['barang' => $barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = DB::table('jenis_barang')->get();
        $kategori = DB::table('kategori_barang')->get();
        $merek = DB::table('merek_barang')->get();

        return view('admin.barang.tambah', ['jenis' => $jenis, 'kategori' => $kategori, 'merek' => $merek]);
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
            'kode' => 'unique:barang',
            'jenis_id' => 'required',
            'kategori_id' => 'required',
            'merek_id' => 'required',
            'foto_1' => 'required|mimes:jpeg,jpg,png'
        ];
  
        $messages = [
            'jenis_id.required'=> 'Harap pilih jenis terlebih dahulu',
            'kategori_id.required'=> 'Harap pilih kategori terlebih dahulu',
            'merek_id.required'=> 'Harap pilih merek terlebih dahulu',
            'kode.unique'=> 'Sudah ada kode barang yang sama',
            'foto_1.required'=> 'Harap unggah foto terlebih dahulu'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $namaFoto1 = "1.".$request->foto_1->getClientOriginalExtension(); 
        $namaFoto2 = $request->foto_2 != null ? "2.".$request->foto_2->getClientOriginalExtension() : null; 
        $namaFoto3 = $request->foto_3 != null ? "3.".$request->foto_3->getClientOriginalExtension(): null;

        $request->foto_1->storeAs('public/images/barang'.$request->kode_barang, $namaFoto1);

        if($namaFoto2 != null || $namaFoto3 != null)
        { 
            $request->foto_2->storeAs('public/images/barang/'.$request->kode_barang, $namaFoto2);
            $request->foto_3->storeAs('public/images/barang/'.$request->kode_barang, $namaFoto3);
        }

        $insert = DB::table('barang')->insert(['kode' => $request->kode, 'nama' => $request->nama, 'deskripsi' => $request->deskripsi, 'harga_jual' => $request->harga_jual, 'diskon_potongan_harga' => $request->diskon_potongan_harga, 'satuan' => 'gram', 'jumlah_stok' => $request->jumlah_stok, 'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa, 'berat' => $request->berat, 'foto_1' => $namaFoto1, 'foto_2' => $namaFoto2, 'foto_3' => $namaFoto3, 'label' => 'labl', 'jenis_id' => $request->jenis_id, 'kategori_id' => $request->kategori_id, 'merek_id' => $request->merek_id, 'batasan_stok_minimal' => 0, 'perkiraan_stok_tambahan' => 0]);

        // kembali ke daftar barang
        return redirect()->route('barang.index');
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
        $jenis = DB::table('jenis_barang')->get();
        $kategori = DB::table('kategori_barang')->get();
        $merek = DB::table('merek_barang')->get();
        $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->where('barang.id', '=', $id)->get();

        return view('admin.barang.ubah', ['barang' => $barang, 'jenis' => $jenis, 'kategori' => $kategori, 'merek' => $merek]);
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
        $update = DB::table('barang')->where('id', $id)->update(['kode' => $request->kode, 'nama' => $request->nama, 'deskripsi' => $request->deskripsi, 'harga_jual' => $request->harga_jual, 'diskon_potongan_harga' => $request->diskon_potongan_harga, 'satuan' => 'gram', 'jumlah_stok' => $request->jumlah_stok, 'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa, 'berat' => $request->berat, 'foto' => '', 'label' => 'labl', 'jenis_id' => $request->jenis_id, 'kategori_id' => $request->kategori_id, 'merek_id' => $request->merek_id, 'batasan_stok_minimal' => 0, 'perkiraan_stok_tambahan' => 0]);
    
        return redirect()->route('barang.index');
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

    public function search(Request $request)
    {
        $barang = null;
        $kriteria = $request->kriteria;
        $keyword = $request->keyword;

        if($kriteria == "Kode")
        {
            $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->where('barang.kode', 'like', '%'.$keyword.'%')->limit(5)->get();
        }
        else 
        {
            $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->where('barang.nama', 'like', '%'.$keyword.'%')->limit(5)->get();
        }

        return response()->json(['barang'=>$barang]);
    }
}
