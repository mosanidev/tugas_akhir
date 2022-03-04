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
                            'tanggal' => \Carbon\Carbon::parse($request->tanggal_pemesanan)->format('Y-m-d'),
                            'perkiraan_tanggal_terima' => \Carbon\Carbon::parse($request->tanggalPerkiraanTerima)->format('Y-m-d'),
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'metode_pembayaran' => $request->metodePembayaran,
                            'status_bayar' => 'Belum lunas',
                            'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggal_jatuh_tempo)->format('Y-m-d'),
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
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        return redirect()->route('pemesanan.index')->with(['success'=>'Data pemesanan berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $history_edit = DB::table('history_edit')
                            ->select('history_edit.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('edit_id', '=', $id)
                            ->where('keterangan', '=', 'pemesanan')
                            ->join('users', 'users.id', '=', 'history_edit.users_id')
                            ->get();

        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('pemesanan.id', '=', $id)
                        ->get();

        $detail_pemesanan = DB::table('detail_pemesanan')
                            ->select('detail_pemesanan.*', 'barang.kode', 'barang.nama')
                            ->join('barang', 'detail_pemesanan.barang_id', '=', 'barang.id')
                            ->where('detail_pemesanan.pemesanan_id', '=', $id)
                            ->get();

        return view('admin.pemesanan.lihat', ['pemesanan' => $pemesanan, 'detail_pemesanan' => $detail_pemesanan, 'history_edit' => $history_edit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('pemesanan.id', '=', $id)
                        ->get();

        $supplier = DB::table('supplier')
                        ->where('jenis', '=', 'Perusahaan')
                        ->get();

        $barang = DB::table('barang')
                        ->where('barang_konsinyasi', '=', '0')
                        ->get();

        $detail_pemesanan = DB::table('detail_pemesanan')
                            ->select('detail_pemesanan.*', 'barang.kode', 'barang.nama')
                            ->join('barang', 'detail_pemesanan.barang_id', '=', 'barang.id')
                            ->where('detail_pemesanan.pemesanan_id', '=', $id)
                            ->get();

        return view('admin.pemesanan.ubah', ['pemesanan' => $pemesanan, 'detail_pemesanan' => $detail_pemesanan, 'supplier' => $supplier, 'barang'=>$barang]);
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
        $update = DB::table('pemesanan')
                        ->where('id', '=', $id)
                        ->update([
                            'nomor_nota' => $request->nomor_nota,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => $request->tanggal_pemesanan,
                            'perkiraan_tanggal_terima' => $request->tanggalPerkiraanTerima,
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'metode_pembayaran' => $request->metodePembayaran,
                            'status_bayar' => 'Belum lunas',
                            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                            'status' => 'Belum diterima di gudang',
                            'total' => $request->total
                        ]);

        $history_edit = DB::table('history_edit')
                            ->insert([
                                'users_id' => auth()->user()->id,
                                'tanggal' => \Carbon\Carbon::now(),
                                'edit_id' => $id,
                                'keterangan' => 'pemesanan'
                            ]);

        $delete = DB::table('detail_pemesanan')
                    ->where('pemesanan_id', '=', $id)
                    ->delete();
        
        $dataBarang = json_decode($request->barang, true);

        for ($i = 0; $i < count((array) $dataBarang); $i++)
        {

            $insertDetailPemesanan = DB::table('detail_pemesanan')
                                            ->insert([
                                                'pemesanan_id'          => $id,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'harga_pesan'           => $dataBarang[$i]['harga_pesan'],
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        return redirect()->route('pemesanan.index')->with(['success'=>'Data pemesanan berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = DB::table('pemesanan')
                    ->where('id', '=', $id)
                    ->delete();

        return redirect()->route('pemesanan.index')->with(['success' => 'Data pemesanan berhasil dihapus']);
    }
}
