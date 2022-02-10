<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminBackOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $back_order = DB::table('back_order')
                        ->select('back_order.*', 'pemesanan.nomor_nota as nomor_nota_pemesanan','pemesanan.tanggal as tanggal_pemesanan', 'supplier.nama as nama_supplier')
                        ->join('pemesanan', 'back_order.pemesanan_id', '=', 'pemesanan.id')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->get();

        return view('admin.back_order.index', ['back_order' => $back_order]);

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
        $back_order = DB::table('back_order')
                        ->select('back_order.*', 'pemesanan.nomor_nota as nomor_nota_pemesanan','pemesanan.tanggal as tanggal_pemesanan', 'supplier.nama as nama_supplier', 'penerimaan_pemesanan.tanggal as tanggal_terima')
                        ->join('pemesanan', 'back_order.pemesanan_id', '=', 'pemesanan.id')
                        ->join('penerimaan_pemesanan', 'penerimaan_pemesanan.pemesanan_id', '=', 'pemesanan.id')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('back_order.id', '=', $id)
                        ->get();

        $detail_barang_dipesan = DB::table('detail_pemesanan')
                                ->select('barang.kode', 'barang.nama', 'detail_pemesanan.harga_pesan', 'detail_pemesanan.kuantitas', 'detail_pemesanan.subtotal')
                                ->join('barang', 'detail_pemesanan.barang_id', '=', 'barang.id')
                                ->where('detail_pemesanan.pemesanan_id', '=', $back_order[0]->pemesanan_id)
                                ->get();

        $detail_barang_belum_diterima = DB::table('detail_back_order')
                                            ->select('barang.kode', 'barang.nama', 'detail_back_order.harga_pesan', 'detail_back_order.kuantitas', 'detail_back_order.subtotal')
                                            ->join('barang', 'detail_back_order.barang_id', '=', 'barang.id')
                                            ->where('detail_back_order.back_order_id', '=', $id)
                                            ->get();

        return view('admin.back_order.lihat', ['back_order' => $back_order, 'detail_barang_dipesan' => $detail_barang_dipesan, 'detail_barang_belum_diterima' => $detail_barang_belum_diterima]);
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
