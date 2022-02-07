<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->get();

        $supplier = DB::table('supplier')
                        ->where('jenis', '=', 'Perusahaan')
                        ->get();

        return view('admin.pemesanan.index', ['pemesanan' => $pemesanan, 'supplier' => $supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = DB::table('supplier')
                    ->where('jenis', '=', 'Perusahaan')
                    ->get();

        $barang = DB::table('barang')
                    ->where('barang_konsinyasi', '=', '0')
                    ->get();

        return view('admin.pemesanan.tambah', ['supplier' => $supplier, 'barang' => $barang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idPemesanan = DB::table('pemesanan')
                            ->insertGetId([
                                'nomor_nota' => $request->nomor_nota,
                                'supplier_id' => $request->supplier_id,
                                'tanggal' => $request->tanggal_pemesanan,
                                'perkiraan_tanggal_terima' => $request->tanggalPerkiraanTerima,
                                'diskon' => $request->diskon,
                                'ppn' => $request->ppn,
                                'metode_pembayaran' => $request->metodePembayaran,
                                'status_bayar' => $request->status,
                                'status' => 'Belum diterima di gudang',
                                'total' => $request->total,
                                'users_id' => auth()->user()->id
                            ]);

        $dataBarang = json_decode($request->barang, true);

        for ($i = 0; $i < count((array) $dataBarang); $i++)
        {

            $insertDetailPemesanan = DB::table('detail_pemesanan')
                                            ->insert([
                                                'pemesanan_id'          => $idPemesanan,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'harga_pesan'           => $dataBarang[$i]['harga_pesan'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        return redirect()->route('pemesanan.index')->with(['success'=>'Data berhasil ditambah']);
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
