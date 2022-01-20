<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konsinyasi = DB::table('konsinyasi')
                        ->select('konsinyasi.id', 'konsinyasi.nomor_nota', 'konsinyasi.tanggal_titip', 'konsinyasi.status', 'konsinyasi.tanggal_jatuh_tempo', 'konsinyasi.supplier_id', 'supplier.nama as nama_supplier', 'supplier.jenis as jenis_supplier')
                        ->leftJoin('retur_pembelian', 'retur_pembelian.pembelian_id', '=', 'konsinyasi.id')
                        ->join('supplier', 'supplier.id', '=', 'konsinyasi.supplier_id')
                        ->where('retur_pembelian.konsinyasi_id', '=', null);

        // select pembelian yang datanya tidak ada di retur pembelian
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.id', 'pembelian.nomor_nota', 'pembelian.tanggal', 'pembelian.status', 'pembelian.tanggal_jatuh_tempo', 'pembelian.supplier_id', 'supplier.nama as nama_supplier', 'supplier.jenis as jenis_supplier')
                        ->leftJoin('retur_pembelian', 'retur_pembelian.pembelian_id', '=', 'pembelian.id')
                        ->join('supplier', 'supplier.id', '=', 'pembelian.supplier_id')
                        ->where('retur_pembelian.pembelian_id', '=', null)
                        ->unionAll($konsinyasi)
                        ->get();


        $retur_pembelian = DB::table('retur_pembelian')
                            ->select('pembelian.nomor_nota as nomor_nota_pembelian', 'konsinyasi.nomor_nota as nomor_nota_konsinyasi', 'retur_pembelian.*', 'supplier.nama as nama_supplier', DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as nama_pembuat"))
                            ->join('pembelian', 'retur_pembelian.pembelian_id', '=', 'pembelian.id')
                            ->join('konsinyasi', 'retur_pembelian.konsinyasi_id', '=', 'konsinyasi.id')
                            ->join('users', 'users.id', '=', 'retur_pembelian.users_id')
                            ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                            // ->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')
                            ->get();

        return view('admin.retur_pembelian.index', ['pembelian' => $pembelian, 'retur_pembelian'=>$retur_pembelian]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $retur_pembelian = DB::table('retur_pembelian')->select('pembelian_id')->pluck('pembelian_id')->toArray();
        $pembelian = DB::table('pembelian')->whereNotIn('id', [$retur_pembelian])->get();
        $detail_pembelian = DB::table('detail_pembelian')->whereNotIn('pembelian_id', [$retur_pembelian])->get();

        // dd($detail_pembelian);

        // $retur_konsinyasi = DB::table('retur_pembelian')->select('konsinyasi_id')->pluck('konsinyasi_id')->toArray();
        // $konsinyasi = DB::table('konsinyasi')->whereNotIn('id', [$retur_konsinyasi])->get();
        // $detail_konsinyasi = DB::table('detail_konsinyasi')->whereNotIn('konsinyasi_id', [$retur_konsinyasi])->get();

        return view('admin.retur_pembelian.tambah', ['pembelian'=>$pembelian, 'detail_pembelian'=>$detail_pembelian]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->jenis == "Pembelian")
        {
            $id_retur_pembelian = DB::table('retur_pembelian')
                                    ->insertGetId([
                                        'nomor_nota' => $request->nomor_nota_retur,
                                        'tanggal' => $request->tanggal,
                                        'users_id' => explode(" - ", $request->pembuat)[0],
                                        'pembelian_id' => $request->id_pembelian,
                                        'kebijakan_retur' => $request->kebijakan_retur
                                    ]);
        }
        else 
        {
            $id_retur_pembelian = DB::table('retur_pembelian')
                                    ->insertGetId([
                                        'nomor_nota' => $request->nomor_nota_retur,
                                        'tanggal' => $request->tanggal,
                                        'users_id' => explode(" - ", $request->pembuat)[0],
                                        'konsinyasi_id' => $request->id_pembelian,
                                        'kebijakan_retur' => $request->kebijakan_retur
                                    ]);
        }
        

        return redirect()->route('retur_pembelian.show', ['retur_pembelian' => $id_retur_pembelian, 'jenis' => $request->jenis]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->jenis == "Pembelian")
        {   
            $retur_pembelian = DB::table('retur_pembelian')
                                ->select('retur_pembelian.*', 'pembelian.nomor_nota as nomor_nota_pembelian', 'pembelian.tanggal as tanggal_buat_nota_beli', 'pembelian.tanggal_jatuh_tempo as tanggal_jatuh_tempo_beli', 'pembelian.status as status_pembelian', DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) AS nama_pembuat"))
                                ->where('retur_pembelian.id', '=', $id)
                                ->join('pembelian', 'pembelian.id', '=', 'retur_pembelian.pembelian_id')
                                ->join('users', 'users.id', '=', 'retur_pembelian.users_id')
                                ->get();

            $detail_pembelian = DB::table('detail_pembelian')
                                    ->select('detail_pembelian.*', 'detail_pembelian.tanggal_kadaluarsa', 'barang.kode', 'barang.nama', 'barang.satuan', 'barang_has_kadaluarsa.jumlah_stok')
                                    ->where('detail_pembelian.pembelian_id', '=', $retur_pembelian[0]->pembelian_id)  
                                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.tanggal_kadaluarsa', '=', 'detail_pembelian.tanggal_kadaluarsa')
                                    ->join('barang', 'barang.id', '=', 'detail_pembelian.barang_id')
                                    ->get();

            // dd($detail_pembelian);

            if($retur_pembelian[0]->kebijakan_retur == "Tukar Barang")
            {
                return view('admin.retur_pembelian.barang_retur.tukar_barang.tukar_barang', ['detail_pembelian' => $detail_pembelian, 'retur_pembelian' => $retur_pembelian]);
            }
            else if ($retur_pembelian[0]->kebijakan_retur == "Potong Dana Pembelian")
            {
                return view('admin.retur_pembelian.barang_retur.potong_dana.pembelian.potong_dana_pembelian', ['detail_pembelian' => $detail_pembelian, 'retur_pembelian' => $retur_pembelian]);
            }
        }
        else // Konsinyasi
        {
            $retur_pembelian = DB::table('retur_pembelian')
                                ->select('retur_pembelian.*', 'konsinyasi.nomor_nota as nomor_nota_pembelian', 'konsinyasi.tanggal_titip as tanggal_buat_nota_beli', 'konsinyasi.tanggal_jatuh_tempo as tanggal_jatuh_tempo_beli', 'konsinyasi.status as status_pembelian', DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) AS nama_pembuat"))
                                ->where('retur_pembelian.id', '=', $id)
                                ->join('konsinyasi', 'konsinyasi.id', '=', 'retur_pembelian.konsinyasi_id')
                                ->join('users', 'users.id', '=', 'retur_pembelian.users_id')
                                ->get();

            $detail_pembelian = DB::table('detail_konsinyasi')
                                    ->select('detail_konsinyasi.*', 'detail_konsinyasi.tanggal_kadaluarsa', 'barang.kode', 'barang.nama', 'barang.satuan', 'barang_has_kadaluarsa.jumlah_stok')
                                    ->where('detail_konsinyasi.konsinyasi_id', '=', $retur_pembelian[0]->konsinyasi_id)  
                                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'detail_konsinyasi.barang_id')
                                    ->join('barang', 'barang.id', '=', 'detail_konsinyasi.barang_id')
                                    ->get();

            // INI KENAPA KOK ADA EMPAT ~?
            // KALO INNER JOIN NYA TANGGAL KADALUARSA DAN KEBETULAN ADA BARANG YANG TGL KADALUARSA SAMA MAKA KELUAR EMPAT DATA

            return view('admin.retur_pembelian.barang_retur.potong_dana.konsinyasi.potong_dana_pembelian', ['detail_pembelian' => $detail_pembelian, 'retur_pembelian' => $retur_pembelian]);
                            
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

    public function loadBarangRetur($id)
    {
        $barang_retur = DB::table('barang')->select('barang.id', 'barang.nama')->join('detail_pembelian', 'barang.id', '=', 'detail_pembelian.barang_id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

        return response()->json(['barang_retur'=>$barang_retur]);
    }

    public function loadInfoBarangRetur($id)
    {
        $barang_retur = DB::table('barang')->select('detail_pembelian.kuantitas', 'detail_pembelian.harga_beli')->join('detail_pembelian', 'barang.id', '=', 'detail_pembelian.barang_id')->where('barang.id', '=', $id)->get();

        return response()->json(['barang_retur'=>$barang_retur]);
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
