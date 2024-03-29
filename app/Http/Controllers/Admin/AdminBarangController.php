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
        $barang = DB::table('barang')
                    ->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')
                    ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                    ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                    ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                    ->orderBy('barang.kode')
                    ->get();

        $jenis = DB::table('jenis_barang')
                    ->get();

        $kategori = DB::table('kategori_barang')
                    ->get();

        $merek = DB::table('merek_barang')
                    ->get();

        return view('admin.barang.index', ['barang' => $barang, 'jenis_barang' => $jenis, 'kategori_barang' => $kategori, 'merek_barang' => $merek]);
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

        $supplier = DB::table('supplier')
                        ->get();

        return view('admin.barang.tambah', ['jenis' => $jenis, 'kategori' => $kategori, 'merek' => $merek, 'supplier' => $supplier]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deskripsi = $request->deskripsi;

        $deskripsi = trim($deskripsi);
        $deskripsi = stripslashes($deskripsi);
        $deskripsi = htmlspecialchars($deskripsi);

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

        $barang_konsinyasi = isset($request->barang_konsinyasi) ? $request->barang_konsinyasi : 0;
        $stok_minimum = isset($request->stok_minimum) ? $request->stok_minimum : 0;

        $barangYgSama = DB::table('barang')
                            ->where('nama', '=', $request->nama)
                            ->where('supplier_id', '=', $request->penitip)
                            ->where('jenis_id', '=', $request->jenis_id)
                            ->where('kategori_id', '=', $request->kategori_id)
                            ->where('merek_id', '=', $request->merek_id)
                            ->get();

        if(count($barangYgSama) > 0)
        {
            $namaDB = strtolower(str_replace(" ", "", $barangYgSama[0]->nama));

            $nama = strtolower(str_replace(" ", "", $request->nama));

            if($namaDB == $nama)
            {
                return redirect()->back()->with(['error' => 'Tidak bisa tambah barang karena sudah ada yang pemasok dengan barang yang sama']);
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        if(isset($request->foto))
        {
            $request->foto->storeAs("public/images/barang/$request->kode/", $request->kode.".".$request->foto->getClientOriginalExtension());
            
            $namaFoto = $request->kode.".".$request->foto->getClientOriginalExtension();
            
            $insert = DB::table('barang')->insert(['kode' => $request->kode, 
                                                    'nama' => $request->nama, 
                                                    'deskripsi' => $deskripsi, 
                                                    'satuan'=>$request->satuan, 
                                                    'harga_jual' => $request->harga_jual, 
                                                    'batasan_stok_minimum' => $stok_minimum, 
                                                    'berat' => $request->berat, 
                                                    'foto' => "/images/barang/$request->kode/".$namaFoto, 
                                                    'jenis_id' => $request->jenis_id, 
                                                    'kategori_id' => $request->kategori_id, 
                                                    'merek_id' => $request->merek_id, 
                                                    'barang_konsinyasi'=>$barang_konsinyasi, 
                                                    'supplier_id' => $request->supplier_id]);
        }
        else 
        {
            $insert = DB::table('barang')->insert(['kode' => $request->kode, 
                                                    'nama' => $request->nama, 
                                                    'deskripsi' => $deskripsi, 
                                                    'satuan'=>$request->satuan, 
                                                    'harga_jual' => $request->harga_jual, 
                                                    'batasan_stok_minimum' => $stok_minimum, 
                                                    'berat' => $request->berat, 
                                                    'jenis_id' => $request->jenis_id, 
                                                    'kategori_id' => $request->kategori_id, 
                                                    'merek_id' => $request->merek_id, 
                                                    'barang_konsinyasi'=>$barang_konsinyasi,
                                                    'supplier_id' => $request->supplier_id]);
        }
        
        // kembali ke daftar barang
        return redirect()->route('barang.index')->with(['success'=>'Data barang telah ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = DB::table('barang')
                    ->select('barang.*', 'jenis_barang.jenis_barang as jenis', 'kategori_barang.kategori_barang as kategori', 'merek_barang.merek_barang as merek')
                    ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                    ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                    ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                    ->where('barang.id', '=', $id)
                    ->get();

        if($barang[0]->supplier_id != null)
        {
            $barang = DB::table('barang')
                        ->select('barang.*', 'jenis_barang.jenis_barang as jenis', 'kategori_barang.kategori_barang as kategori', 'merek_barang.merek_barang as merek', 'supplier.nama as nama_penitip')
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->join('supplier', 'barang.supplier_id', '=', 'supplier.id')
                        ->where('barang.id', '=', $id)
                        ->get();
        }

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
        $supplier = DB::table('supplier')->get();
        $barang = DB::table('barang')->select('barang.*', 'jenis_barang.jenis_barang', 'kategori_barang.kategori_barang', 'merek_barang.merek_barang')->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')->where('barang.id', '=', $id)->get();

        $files = Storage::disk('public')->allFiles("images/barang/".$barang[0]->kode);

        return view('admin.barang.ubah', ['barang' => $barang, 'jenis' => $jenis, 'kategori' => $kategori, 'merek' => $merek, 'id' => $barang[0]->id, 'files' => $files, 'supplier' => $supplier]);
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

        $barang_konsinyasi = isset($request->barang_konsinyasi) ? $request->barang_konsinyasi : 0;
        $stok_minimum = isset($request->stok_minimum) ? $request->stok_minimum : 0;
  
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
            
            $update = DB::table('barang')
                        ->where('id', '=', $id)
                        ->update(['jenis_id'=>$request->jenis_id, 
                                  'kategori_id'=>$request->kategori_id, 
                                  'merek_id'=>$request->merek_id, 
                                  'kode'=>$request->kode, 
                                  'satuan'=>$request->satuan, 
                                  'nama'=>$request->nama, 
                                  'deskripsi'=>$request->deskripsi, 
                                  'barang_konsinyasi' => $barang_konsinyasi, 
                                  'batasan_stok_minimum' => $stok_minimum, 
                                  'harga_jual'=>$request->harga_jual, 
                                  'foto' => "/images/barang/$request->kode/".$namaFoto, 
                                  'berat'=>$request->berat,
                                  'supplier_id' => $request->supplier_id]);
        }
        else if( $request->keterangan_foto == "Foto dihapus" ) 
        {
            $update = DB::table('barang')
                        ->where('id', '=', $id)
                        ->update(['jenis_id'=>$request->jenis_id, 
                                  'kategori_id'=>$request->kategori_id, 
                                  'merek_id'=>$request->merek_id, 
                                  'kode'=>$request->kode, 
                                  'satuan'=>$request->satuan, 
                                  'nama'=>$request->nama, 
                                  'deskripsi'=>$request->deskripsi, 
                                  'barang_konsinyasi' => $barang_konsinyasi, 
                                  'batasan_stok_minimum' => $stok_minimum, 
                                  'harga_jual'=>$request->harga_jual,
                                  'foto' => '/images/barang/barang_null.png', 
                                  'berat'=>$request->berat,
                                  'supplier_id' => $request->supplier_id]);
        }
        else 
        {
            $update = DB::table('barang')
                        ->where('id', '=', $id)
                        ->update(['jenis_id'=>$request->jenis_id, 
                                  'kategori_id'=>$request->kategori_id, 
                                  'merek_id'=>$request->merek_id, 
                                  'kode'=>$request->kode, 
                                  'satuan'=>$request->satuan, 
                                  'nama'=>$request->nama, 
                                  'deskripsi'=>$request->deskripsi, 
                                  'barang_konsinyasi' => $barang_konsinyasi, 
                                  'batasan_stok_minimum' => $stok_minimum, 
                                  'harga_jual'=>$request->harga_jual, 
                                  'berat'=>$request->berat,
                                  'supplier_id' => $request->supplier_id]);
        }

        // kembali ke daftar barang
        return redirect()->route('barang.index')->with(['success'=>'Data barang telah diubah']);
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

        return redirect()->back()->with(['success'=>'Data barang berhasil dihapus']);
    }

    public function viewStokBarang()
    {
        $barang = DB::table('barang')
                        ->select('barang.id as barang_id', 
                                'barang.kode', 
                                'barang.nama', 
                                'barang.satuan',
                                'jenis_barang.jenis_barang as nama_jenis', 
                                'barang.barang_konsinyasi', 
                                'barang.batasan_stok_minimum'
                                ) 
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->whereNotIn('barang.id',function($query){
                            $query->select('barang_id')->from('barang_has_kadaluarsa');
                         })
                        ->groupBy('barang.id')
                        ->orderBy('nama')
                        ->get();

        $barangStok = DB::table('barang')
                        ->select('barang.id as barang_id',
                                'barang.kode', 
                                'barang.nama', 
                                'barang.satuan', 
                                'jenis_barang.jenis_barang as nama_jenis',  
                                'barang.batasan_stok_minimum', 
                                'barang.barang_konsinyasi', 
                                DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'),
                                'barang_has_kadaluarsa.tanggal_kadaluarsa'
                                )
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->groupBy('barang.id')
                        ->orderBy('barang.kode')
                        ->get();

        $stokBarang = DB::table('barang')
                        ->select('barang.id as barang_id', 
                                 DB::raw("CONCAT(barang.kode, ' - ', barang.nama) as nama"), 
                                 'jenis_barang.jenis_barang as nama_jenis', 
                                 'kategori_barang.kategori_barang as nama_kategori', 
                                 'merek_barang.merek_barang as nama_merek', 
                                 'barang.batasan_stok_minimum')
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        ->groupBy('barang.id')
                        ->orderBy('nama')
                        ->get();

        $jenis_barang = DB::table('jenis_barang')
                            ->select('jenis_barang.jenis_barang as nama_jenis')
                            ->get();

        return view('admin.barang.stok.index', ['barang' => $barang, 'barangStok' => $barangStok, 'stokBarang' => $stokBarang, 'jenis_barang' => $jenis_barang]);
    }

    public function filter(Request $request)
    {
        $jenis_barang = $request->jenis_barang;
        $masa_kadaluarsa = $request->masa_kadaluarsa;
        $status_stok_gudang = $request->status_stok_gudang;
        $status_stok_rak = $request->status_stok_rak;
        $tipe_barang = $request->tipe_barang;

        $barang = DB::table('barang')
                        ->select('barang.id as barang_id', 
                                'barang.kode', 
                                'barang.nama', 
                                'barang.satuan',
                                'jenis_barang.jenis_barang as nama_jenis', 
                                'barang.barang_konsinyasi', 
                                'barang.batasan_stok_minimum'
                                ) 
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->whereNotIn('barang.id',function($query){
                            $query->select('barang_id')->from('barang_has_kadaluarsa');
                         })
                        ->groupBy('barang.id')
                        ->orderBy('barang.kode');

        $barangStok = DB::table('barang')
                        ->select('barang.id as barang_id',
                                'barang.kode', 
                                'barang.nama', 
                                'barang.satuan', 
                                'jenis_barang.jenis_barang as nama_jenis',  
                                'barang.batasan_stok_minimum', 
                                'barang.barang_konsinyasi', 
                                DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'),
                                'barang_has_kadaluarsa.tanggal_kadaluarsa'
                                )
                        ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                        ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                        ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                        ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                        // ->whereRaw('barang_has_kadaluarsa.tanggal_kadaluarsa >= SYSDATE()')
                        ->groupBy('barang.id')
                        ->orderBy('barang.kode');

        dd($barangStok->get());

        if($jenis_barang != "Semua")
        {
            $barang->where('jenis_barang.jenis_barang', '=', $jenis_barang);
            $barangStok->where('jenis_barang.jenis_barang', '=', $jenis_barang);

        }

        $barang = $barang->get();
        $barangStok = $barangStok->get();

        return response()->json(['barang'=>$barang, 'barangStok'=>$barangStok]);
    
    }

    public function viewDetailStokBarang($id)
    {
        $detailStokBarang = DB::table('barang_has_kadaluarsa')
                                ->select('jenis_barang.jenis_barang as nama_jenis',
                                         'kategori_barang.kategori_barang as nama_kategori',
                                         'merek_barang.merek_barang as nama_merek',
                                         'barang.batasan_stok_minimum',
                                         'barang_has_kadaluarsa.tanggal_kadaluarsa', 
                                         'barang_has_kadaluarsa.jumlah_stok', 
                                         'barang.barang_konsinyasi')
                                ->where('barang_has_kadaluarsa.barang_id', '=', $id)
                                ->join('barang', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                                ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id')
                                ->join('kategori_barang', 'barang.kategori_id', '=', 'kategori_barang.id')
                                ->join('merek_barang', 'barang.merek_id', '=', 'merek_barang.id')
                                ->get();

        return response()->json(['detail'=>$detailStokBarang]);
    }

    public function viewKadaluarsaBarang()
    {
        $barang = DB::table('barang')
                    ->select('barang.id as barang_id',
                             'barang_has_kadaluarsa.tanggal_kadaluarsa',
                             'barang_has_kadaluarsa.jumlah_stok',
                             'jenis_barang.jenis_barang',
                             'kategori_barang.kategori_barang',
                             'barang.kode',
                             'barang.satuan',
                             'barang.nama',
                             'barang.barang_konsinyasi')
                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                    ->join('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_id')
                    ->join('kategori_barang', 'kategori_barang.id', '=', 'barang.kategori_id')
                    ->get();

        $jenis_barang = DB::table('jenis_barang')
                            ->get();

        $kategori_barang = DB::table('kategori_barang')
                            ->get();

        return view('admin.barang.kadaluarsa.index', ['barang' => $barang, 'jenis_barang' => $jenis_barang, 'kategori_barang' => $kategori_barang]);
    }
}
