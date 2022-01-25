<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $penjualan = DB::table('detail_penjualan')
        //                 ->select(DB::raw("CONCAT()") 'penjualan.tanggal as tanggal_jual', 'penjualan.status', DB::raw("CONCAT('alamat_pengiriman.alamat', ' ', 'alamat_pengiriman.provinsi', ' ', 'alamat_pengiriman.kota_kabupaten', ' ', ''alamat_pengiriman.kecamatan') as alamat"), 'shipper.nama as pengirim', 'pengiriman.jenis_pengiriman', 'pengiriman.kode_jenis_pengiriman', 'pengiriman.estimasi_tiba', 'pengiriman.total_berat', 'pengiriman.tarif as tarif_pengiriman')
        //                 ->whereNotNull('detail_penjualan.pengiriman_id')
        //                 ->whereNotNull('detail_penjualan.alamat_pengiriman_id')
        //                 ->where('penjualan.status', '=', 'Pesanan sudah dibayar dan sedang disiapkan')
        //                 ->whereNotIn("penjualan.metode_transaksi", ['Ambil di toko'])
        //                 ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
        //                 ->join('pengiriman', 'detail_penjualan.pengiriman_id', '=', 'pengiriman.id')
        //                 ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
        //                 ->join('shipper', 'shipper.kode', '=', 'pengiriman.kode_shipper')
        //                 ->join('alamat_pengiriman', 'detail_penjualan.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')
        //                 ->get();

        /*
            nomor_nota
            tanggal
            status
            pengirim
            kode_jenis_pengiriman
            jenis_pengiriman
            alamt tujuan
            estimasi tiba
            tarif pengiriman
            total berat

            nama_penerima
            nomor_telepon
            email_penerima
            alamat
            kode pos
            latitude 
            longitude

            barang yang dijual
        */

        $penjualan = DB::table('detail_penjualan')->get();

        return view('admin.pengiriman.index', ['penjualan' => $penjualan]);
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
        dd($id);
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
