<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminStokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomorStokOpname = DB::table('stok_opname')
                            ->select(DB::raw('max(id) as nomor_stok_opname'))
                            ->get();

        $nomor_stok_opname = $nomorStokOpname[0]->nomor_stok_opname;
        if($nomor_stok_opname == null)
        {
            $nomor_stok_opname = 1;
        }
        else 
        {
            $nomor_stok_opname += 1;
        }

        return view('admin.stok_opname.index', ['nomor_stok_opname' => $nomor_stok_opname]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.kode', 'barang.nama')
                    ->where('barang_konsinyasi', '=', 0)->get();

        $barangTglKadaluarsa = DB::table('barang_has_kadaluarsa')
                    ->select('barang.*', 'barang_has_kadaluarsa.tanggal_kadaluarsa as tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as jumlah_stok')
                    ->join('barang', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->whereRaw('barang_has_kadaluarsa.tanggal_kadaluarsa > SYSDATE()')
                    ->where('barang.barang_konsinyasi', '=', 0)->get();

        // dd($barang);
        // dd($barangTglKadaluarsa);

        return view('admin.stok_opname.tambah', ['barang'=>$barang, 'barangTglKadaluarsa'=>$barangTglKadaluarsa]);
    }

    public function storeStokOpname($id)
    {
        $stokOpname = DB::table('stok_opname')
                            ->select('stok_opname.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('stok_opname.id', $id)
                            ->join('users', 'stok_opname.users_id', '=', 'users.id')
                            ->get();

        if($stokOpname[0]->lokasi_stok == "Gudang")
        {
            $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                    ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as jumlah_stok')
                                    ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                    ->get();
        }
        else 
        {
            $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                        ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_rak as jumlah_stok')
                                        ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                        ->get();
        }

        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.kode', 'barang.nama')
                    ->get();

        return view('admin.stok_opname.tambah', ['stok_opname' => $stokOpname, 'barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang])->with(['success' => 'Data transfer barang berhasil ditambah. Silahkan lengkapi barang yang ditransfer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $IDstokOpname = DB::table('stok_opname')
                         ->insertGetId([
                             'tanggal' => $request->tanggal,
                             'users_id' => auth()->user()->id,
                             'lokasi_stok' => $request->lokasi_stok
                         ]);

        return redirect()->route('stok_opname.storeStokOpname', ['stok_opname' => $IDstokOpname]);

    }

    public function storeDetailStokOpname(Request $request)
    {
        $dataBarang = json_decode($request->barang, true);

        for($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $insertDetailStokOpname = DB::table('detail_stok_opname')
                                        ->insert([
                                            'stok_opname_id' => $request->stok_opname_id,
                                            'barang_id' => $dataBarang[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $dataBarang[$i]['barang_tanggal_kadaluarsa'],
                                            'stok_di_sistem' => $dataBarang[$i]['stok_di_sistem'],
                                            'stok_di_toko' => $dataBarang[$i]['stok_di_toko'],
                                            'jumlah_selisih' => $dataBarang[$i]['selisih'],
                                            'keterangan' => $dataBarang[$i]['keterangan']
                                        ]);

            if($request->lokasi_stok == "Rak")
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_rak', $dataBarang[$i]['selisih']);
            }
            else 
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_gudang', $dataBarang[$i]['selisih']);
            }
        }

        return redirect()->route('stok_opname.index')->with(['success' => 'Data berhasil ditambah']);
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
