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
        return view('admin.stok_opname.index');
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

        $barangTglKadaluarsa = DB::table('barang')
                    ->select('barang.*', 'barang_has_kadaluarsa.tanggal_kadaluarsa as tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok as jumlah_stok')
                    ->join('barang_has_kadaluarsa', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->whereRaw('barang_has_kadaluarsa.tanggal_kadaluarsa > SYSDATE()')
                    ->where('barang_konsinyasi', '=', 0)->get();

        // dd($barang);
        // dd($barangTglKadaluarsa);

        return view('admin.stok_opname.tambah', ['barang'=>$barang, 'barangTglKadaluarsa'=>$barangTglKadaluarsa]);
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
                             'nomor_nota' => $request->nomor_nota,
                             'tanggal' => $request->tanggal,
                             'users_id' => auth()->user()->id
                         ]);

        $dataBarang = json_decode($request->barang, true);

        for($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $insertDetailStokOpname = DB::table('detail_stok_opname')
                                        ->insert([
                                            'stok_opname_id' => $IDstokOpname,
                                            'barang_id' => $dataBarang[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $dataBarang[$i]['barang_tanggal_kadaluarsa'],
                                            'stok_di_sistem' => $dataBarang[$i]['stok_di_sistem'],
                                            'stok_di_toko' => $dataBarang[$i]['stok_di_toko'],
                                            'jumlah_selisih' => $dataBarang[$i]['selisih'],
                                            'keterangan' => $dataBarang[$i]['keterangan']
                                        ]);

            $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                            ->increment('jumlah_stok', $dataBarang[$i]['selisih']);

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
