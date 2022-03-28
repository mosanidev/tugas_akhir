<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retur_penjualan = DB::table('retur_penjualan')
                            ->select('retur_penjualan.id',
                                     'penjualan.nomor_nota', 
                                     'users.nama_depan', 
                                     'users.nama_belakang', 
                                     'penjualan.tanggal as tanggal_jual',
                                     'retur_penjualan.tanggal as tanggal_retur',
                                     'retur_penjualan.jenis_retur',
                                     'retur_penjualan.status')
                            ->join('penjualan', 'penjualan.id', '=', 'retur_penjualan.penjualan_id')
                            ->join('users', 'retur_penjualan.users_id', '=', 'users.id')
                            ->get();

        return view('admin.retur_penjualan.index', ['retur_penjualan' => $retur_penjualan]);
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

    public function tampilkanNomorRekening($id)
    {
        $rekeningRetur = DB::table('retur_penjualan')
                            ->select('rekening_retur.bank', 'rekening_retur.nama_pemilik_rekening', 'rekening_retur.nomor_rekening', 'retur_penjualan.total')
                            ->where('retur_penjualan.id', '=', $id)
                            ->join('rekening_retur', 'rekening_retur.id', '=', 'retur_penjualan.rekening_retur_id')
                            ->get();

        return response()->json(['rekening_retur' => $rekeningRetur]);
    }

    public function lunasiRefund($id, Request $request)
    {

        if(isset($request->foto_bayar))
        {
            $request->foto_bayar->storeAs("public/images/bukti_refund/", $id.".".$request->foto_bayar->getClientOriginalExtension());
            
            $namaFoto = $id.".".$request->foto_bayar->getClientOriginalExtension();

            $updateRetur = DB::table('retur_penjualan')
                            ->where('id', '=', $id)
                            ->update([
                                'foto_bukti_pengembalian_dana' => $namaFoto,
                                'status' => 'Pengembalian dana telah dilakukan'
                            ]);
        }
        else 
        {
            $updateRetur = DB::table('retur_penjualan')
                            ->where('id', '=', $id)
                            ->update([
                                'status' => 'Pengembalian dana telah dilakukan'
                            ]);

        }

        // $returPenjualan = DB::table('detail_retur_penjualan')
        //                         ->where('retur_penjualan_id', '=', $id)
        //                         ->get();

        // foreach($returPenjualan as $item)
        // {
        //     $kembalikanBarangReturKeStok = DB::table('barang_has_kadaluarsa')
        //                                 ->where('barang_id', '=', $item->barang_retur)
        //                                 ->increment('jumlah_stok', $item->kuantitas_barang_retur);
        // }

        return redirect()->back()->with(['success' => 'Pengembalian dana berhasil dicatat']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retur_penjualan = DB::table('retur_penjualan')
                            ->select('retur_penjualan.id',
                                     'penjualan.nomor_nota', 
                                     'users.nama_depan', 
                                     'users.nama_belakang', 
                                     'penjualan.tanggal as tanggal_jual',
                                     'retur_penjualan.tanggal as tanggal_retur',
                                     'retur_penjualan.status',
                                     'retur_penjualan.link')
                            ->join('penjualan', 'penjualan.id', '=', 'retur_penjualan.penjualan_id')
                            ->join('users', 'retur_penjualan.users_id', '=', 'users.id')
                            ->where('retur_penjualan.id', '=', $id)
                            ->get();

        $detail_retur_penjualan = DB::table('detail_retur_penjualan')
                                    ->select('detail_retur_penjualan.*', 'barang.kode', 'barang.nama')
                                    ->join('barang', 'barang.id', '=', 'detail_retur_penjualan.barang_retur')
                                    ->where('detail_retur_penjualan.retur_penjualan_id', '=', $id)
                                    ->get();

        return view('admin.retur_penjualan.lihat', ['retur_penjualan' => $retur_penjualan, 'detail_retur_penjualan' => $detail_retur_penjualan]);
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
        $returPenjualan = DB::table('retur_penjualan')
                            ->where('id', '=', $id)
                            ->get();

        if($request->status_retur == "Harap tunggu pengembalian dana dari admin" && $returPenjualan[0]->rekening_retur_id == null)
        {
            return redirect()->back()->with(['error' => 'Gagal ubah status menjadi "Harap tunggu pengembalian dana dari admin" karena belum ada data rekening tujuan pengembalian dana']);
        }

        $updateStatus = DB::table('retur_penjualan')
                        ->where('id', '=', $id)
                        ->update([
                            'status' => $request->status_retur
                        ]);

        if($request->status_retur == "Pengajuan retur ditolak admin")
        {
            $updatePenjualan = DB::table('penjualan')
                                ->where('penjualan.id', '=',  $returPenjualan[0]->id)
                                ->update([
                                    'status_retur' => 'Tidak Ada Retur'
                                ]);
        }

        $notifikasi = DB::table('notifikasi')
                        ->where('penjualan_id', '=', $returPenjualan[0]->penjualan_id)
                        ->update([
                            'isi' => "Status pengajuan retur diubah menjadi ".$request->status_retur,
                            'status' => 'Belum dilihat',
                            'updated_at' => \Carbon\Carbon::now()
                        ]);

        return redirect()->route('retur_penjualan.index')->with(['success' => 'Data retur penjualan berhasil diubah']);
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
