<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use Storage;
use Illuminate\Validation\Rule;

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
            'satuan' => 'required'
        ];
  
        $messages = [
            'jenis_id.required'=> 'Harap pilih jenis terlebih dahulu',
            'kategori_id.required'=> 'Harap pilih kategori terlebih dahulu',
            'merek_id.required'=> 'Harap pilih merek terlebih dahulu',
            'kode.unique'=> 'Sudah ada kode barang yang sama',
            'satuan.required'=> 'Harap pilih satuan barang terlebih dahulu'

        ];

        $jam_kadaluarsa = isset($request->jam_kadaluarsa) ? \Carbon\Carbon::parse($request->jam_kadaluarsa)->format('H:i:s') : '23:59:59';
        $barang_konsinyasi = isset($request->barang_konsinyasi) ? $request->barang_konsinyasi : 0;
        $harga_beli = isset($request->harga_beli) ? $request->harga_beli : 0;
        $komisi = isset($request->komisi) ? $request->komisi : 0;
        $stok_minimum = isset($request->stok_minimum) ? $request->stok_minimum : 0;
        $opsi_otomatis_update_kadaluarsa = isset($request->opsi_otomatis_update_kadaluarsa) ? $request->opsi_otomatis_update_kadaluarsa : 0;

        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if(isset($request->foto))
        {
            $request->foto->storeAs("public/images/barang/$request->kode/", $request->kode.".".$request->foto->getClientOriginalExtension());
            
            $namaFoto = $request->kode.".".$request->foto->getClientOriginalExtension();
            
            $insert = DB::table('barang')->insert(['kode' => $request->kode, 'nama' => $request->nama, 'deskripsi' => $request->deskripsi, 'satuan'=>$request->satuan, 'harga_beli'=>$harga_beli, 'harga_jual' => $request->harga_jual, 'komisi'=>$komisi, 'batasan_stok_minimum' => $stok_minimum, 'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa, 'opsi_otomatis_update_kadaluarsa'=>$opsi_otomatis_update_kadaluarsa, 'berat' => $request->berat, 'foto' => "/images/barang/$request->kode/".$namaFoto, 'jenis_id' => $request->jenis_id, 'kategori_id' => $request->kategori_id, 'merek_id' => $request->merek_id, 'barang_konsinyasi'=>$barang_konsinyasi, 'jam_kadaluarsa'=>$jam_kadaluarsa]);
        }
        else 
        {
            $insert = DB::table('barang')->insert(['kode' => $request->kode, 'nama' => $request->nama, 'deskripsi' => $request->deskripsi, 'satuan'=>$request->satuan, 'harga_beli'=>$harga_beli, 'harga_jual' => $request->harga_jual, 'komisi'=>$komisi, 'batasan_stok_minimum' => $stok_minimum, 'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa, 'opsi_otomatis_update_kadaluarsa'=>$opsi_otomatis_update_kadaluarsa, 'berat' => $request->berat, 'jenis_id' => $request->jenis_id, 'kategori_id' => $request->kategori_id, 'merek_id' => $request->merek_id, 'barang_konsinyasi'=>$barang_konsinyasi, 'jam_kadaluarsa'=>$jam_kadaluarsa]);
        }
        
        // kembali ke daftar barang
        return redirect()->route('barang.index')->with(['status'=>'Data barang telah ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang as jenis', 'kategori_barang.kategori_barang as kategori', 'merek_barang.merek_barang as merek')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->where('barang.id', '=', $id)->get();

        return view('admin.barang.lihat', ['barang'=>$barang]);
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

        $tanggal_kadaluarsa = $barang[0]->tanggal_kadaluarsa;
        $jam_kadaluarsa = $barang[0]->jam_kadaluarsa;

        $dateNow = \Carbon\Carbon::now();

        $date = \Carbon\Carbon::parse($barang[0]->tanggal_kadaluarsa." ".$barang[0]->jam_kadaluarsa);   

        $diffInHours = $dateNow->diffInHours($date);

        dd($diffInHours);

        $files = Storage::disk('public')->allFiles("images/barang/".$barang[0]->kode);

        return view('admin.barang.ubah', ['barang' => $barang, 'jenis' => $jenis, 'kategori' => $kategori, 'merek' => $merek, 'id' => $barang[0]->id, 'files' => $files]);
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
        $cek_kode = DB::table('barang')->select('kode')->whereNotIn('id', [$id])->get();

        $cari = false;

        for($i=0; $i<count($cek_kode); $i++)
        {
            if(strtolower($request->kode) == strtolower($cek_kode[$i]->kode))
            {
                $cari = true;
            }
        }

        $jam_kadaluarsa = isset($request->jam_kadaluarsa) ? \Carbon\Carbon::parse($request->jam_kadaluarsa)->format('H:i:s') : '23:59:59';
        $barang_konsinyasi = isset($request->barang_konsinyasi) ? $request->barang_konsinyasi : 0;
        $harga_beli = isset($request->harga_beli) ? $request->harga_beli : 0;
        $komisi = isset($request->komisi) ? $request->komisi : 0;
        $stok_minimum = isset($request->stok_minimum) ? $request->stok_minimum : 0;
        $opsi_otomatis_update_kadaluarsa = isset($request->opsi_otomatis_update_kadaluarsa) ? $request->opsi_otomatis_update_kadaluarsa : 0;
  
        if($cari){
            return redirect()->back()->withErrors(['msg' => 'Kode barang sudah ada'])->withInput($request->all);
        }

        $rules = [
            'jenis_id' => 'required',
            'kategori_id' => 'required',
            'merek_id' => 'required'
        ];
  
        $messages = [
            'jenis_id.required'=> 'Harap pilih jenis terlebih dahulu',
            'kategori_id.required'=> 'Harap pilih kategori terlebih dahulu',
            'merek_id.required'=> 'Harap pilih merek terlebih dahulu'
        ];

        if(isset($request->foto))
        {
            $request->foto->storeAs("public/images/barang/$request->kode/", $request->kode.".".$request->foto->getClientOriginalExtension());
            
            $namaFoto = $request->kode.".".$request->foto->getClientOriginalExtension();
            
            $update = DB::table('barang')->where('id', '=', $id)->update(['jenis_id'=>$request->jenis_id, 'kategori_id'=>$request->kategori_id, 'merek_id'=>$request->merek_id, 'kode'=>$request->kode, 'satuan'=>$request->satuan, 'nama'=>$request->nama, 'deskripsi'=>$request->deskripsi, 'harga_beli'=>$harga_beli, 'barang_konsinyasi' => $barang_konsinyasi, 'komisi' => $komisi, 'batasan_stok_minimum' => $stok_minimum, 'opsi_otomatis_update_kadaluarsa' => $opsi_otomatis_update_kadaluarsa, 'harga_jual'=>$request->harga_jual, 'foto' => "/images/barang/$request->kode/".$namaFoto, 'berat'=>$request->berat, 'tanggal_kadaluarsa'=>$request->tanggal_kadaluarsa, 'jam_kadaluarsa'=>$jam_kadaluarsa]);
        }
        else 
        {
            $update = DB::table('barang')->where('id', '=', $id)->update(['jenis_id'=>$request->jenis_id, 'kategori_id'=>$request->kategori_id, 'merek_id'=>$request->merek_id, 'kode'=>$request->kode, 'satuan'=>$request->satuan, 'nama'=>$request->nama, 'deskripsi'=>$request->deskripsi, 'harga_beli'=>$harga_beli, 'barang_konsinyasi' => $barang_konsinyasi, 'komisi' => $komisi, 'batasan_stok_minimum' => $stok_minimum, 'opsi_otomatis_update_kadaluarsa' => $opsi_otomatis_update_kadaluarsa, 'harga_jual'=>$request->harga_jual, 'berat'=>$request->berat, 'tanggal_kadaluarsa'=>$request->tanggal_kadaluarsa, 'jam_kadaluarsa'=>$jam_kadaluarsa]);
        }

        // kembali ke daftar barang
        return redirect()->route('barang.index')->with(['status'=>'Data barang telah diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_barang = DB::table('barang')->where('id', '=', $id)->delete();

        return redirect()->back()->with(['status'=>'Data barang berhasil dihapus']);
    }
}
