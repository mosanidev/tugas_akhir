<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminKonsinyasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konsinyasi = DB::table('konsinyasi')->select('konsinyasi.*', 'supplier.nama as nama_supplier')->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')->get();
        $supplier = DB::table('supplier')->get();

        return view('admin.konsinyasi.index', ['konsinyasi' => $konsinyasi, 'supplier' => $supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = DB::table('supplier')->where('jenis', '=', 'Individu')->get();
        $barang_konsinyasi = DB::table('barang')->where('barang_konsinyasi', '=', 0)->get();

        return view('admin.konsinyasi.tambah', ['supplier' => $supplier, 'barang_konsinyasi' => $barang_konsinyasi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $konsinyasi_id = DB::table('konsinyasi')->insertGetId([
                                                    'nomor_nota' => $request->nomor_nota, 
                                                    'tanggal_titip' => $request->tanggal_titip, 
                                                    'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo, 
                                                    'supplier_id' => $request->supplier_id, 
                                                    'metode_pembayaran' => $request->metode_pembayaran, 
                                                    'status' => $request->status, 
                                                    'total_komisi' => $request->total_komisi ]);

        $barangKonsinyasi = json_decode($request->barangKonsinyasi, true);
        
        for($i = 0; $i < count((array) $barangKonsinyasi); $i++)
        {
            $insertDetailKonsinyasi = DB::table('detail_konsinyasi')
                                        ->insert([
                                            'konsinyasi_id' => $konsinyasi_id,
                                            'barang_id' => $barangKonsinyasi[$i]['barang_id'],
                                            'jumlah_titip' => $barangKonsinyasi[$i]['jumlah_titip'],
                                            'komisi' => $barangKonsinyasi[$i]['komisi'],
                                            'subtotal_komisi' => $barangKonsinyasi[$i]['subtotal_komisi']
                                        ]);

            $tambahStokBarangKonsinyasi = DB::table('barang_has_kadaluarsa')
                                            ->insert([
                                                'barang_id' => $barangKonsinyasi[$i]['barang_id'],
                                                'tanggal_kadaluarsa' => $barangKonsinyasi[$i]['tanggal_kadaluarsa'],
                                                'jumlah_stok' => $barangKonsinyasi[$i]['jumlah_titip']
                                            ]);
         }

        return redirect()->route('konsinyasi.index')->with(['success' => 'Data berhasil ditambah']);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $konsinyasi = DB::table('konsinyasi')->select('konsinyasi.*', 'supplier.nama as nama_supplier')->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')->where('konsinyasi.id', '=', $id)->get();

        $barang = DB::table('barang')->where('barang_konsinyasi', '=', 1)->get();
        $barangKonsinyasi = DB::table('detail_konsinyasi')->select('detail_konsinyasi.*', 'barang.nama as nama_barang')->join('barang', 'detail_konsinyasi.barang_id', '=', 'barang.id')->where('detail_konsinyasi.konsinyasi_id', '=', $id)->get();
        $supplier = DB::table('supplier')->get();

        $this->loadKonsinyasi($konsinyasi, $barangKonsinyasi);

        if($request->ajax())
        {
            return response()->json($konsinyasi);
        }
        else 
        {
            return view('admin.konsinyasi.detail.index', ['konsinyasi' => $konsinyasi, 'barang' => $barang, 'barangKonsinyasi' => $barangKonsinyasi, 'supplier' => $supplier]);
        }
    }

    public function loadKonsinyasi($konsinyasi, $barangKonsinyasi)
    {
        $tanggalTitip = $konsinyasi[0]->tanggal_titip;
        $tanggalJatuhTempo = $konsinyasi[0]->tanggal_jatuh_tempo;

        $terjual = 0;
        $hutang = 0;
        $komisi = 0;

        for($i = 0; $i < count($barangKonsinyasi); $i++)
        {
            $penjualan = DB::table('detail_penjualan')
                        ->select('detail_penjualan.*', 'barang.*')
                        ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                        ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
                        ->where('detail_penjualan.barang_id', '=', $barangKonsinyasi[$i]->barang_id)
                        ->where('penjualan.status', '=', 'Pesanan sudah dibayar dan sedang disiapkan')
                        ->whereBetween('tanggal', [$konsinyasi[0]->tanggal_titip, $konsinyasi[0]->tanggal_jatuh_tempo])
                        ->get();

            // $terjual += $penjualan[$i]->kuantitas;
            // $hutang += $penjualan[$i]->subtotal;
            // $komisi += $penjualan[$i]->komisi;

            // if(count($penjualan) > 0)
            // {
                // $update = DB::table('detail_konsinyasi')->where('konsinyasi_id', '=', $konsinyasi[0]->id)->where('barang_id', '=', $barangKonsinyasi[$i]->barang_id)->update(['terjual' => $terjual, 'total_hutang' => $hutang, 'total_komisi' => $komisi]);
                // $arr[$i] = [ 'konsinyasi_id' => $konsinyasi[0]->id, 'barang_id' => $barangKonsinyasi[$i]->barang_id, 'kuantitas' => $penjualan[$i]->kuantitas, 'subtotal' => $penjualan[$i]->subtotal, 'komisi' => $penjualan[$i]->komisi];
            // }
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
        $update = DB::table('konsinyasi')->where('id', $id)
                    ->update([
                        'nomor_nota' => $request->nomor_nota,
                        'supplier_id' => $request->supplier_id,
                        'tanggal_titip' => $request->tanggal_titip,
                        'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                        'metode_pembayaran' => $request->metode_pembayaran,
                        'status' => $request->status
                    ]);

        return redirect()->back()->with(['success', 'Data berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('konsinyasi')->where('id', $id)->delete();

        return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
    }
}
