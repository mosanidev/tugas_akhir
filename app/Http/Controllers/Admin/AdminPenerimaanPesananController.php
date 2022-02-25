<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPenerimaanPesananController extends Controller
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

        return view('admin.penerimaan_pesanan.index', ['pemesanan' => $pemesanan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request);
    }

    public function prosesTerima($id)
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.id as supplier_id', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('pemesanan.id', '=', $id)
                        ->get();
         
        $detail_pemesanan = DB::table('detail_pemesanan')
                            ->select('detail_pemesanan.*', 'barang.id', 'barang.kode', 'barang.nama', 'barang.harga_jual')
                            ->where('detail_pemesanan.pemesanan_id', '=', $id)
                            ->join('barang', 'detail_pemesanan.barang_id', '=', 'barang.id')
                            ->get();

        return view('admin.penerimaan_pesanan.proses_terima', ['pemesanan' => $pemesanan, 'detail_pemesanan' => $detail_pemesanan]);
    }

    // public function prosesTerimaSebagian($id)
    // {
    //     $pemesanan = DB::table('pemesanan')
    //                     ->select('pemesanan.*', 'supplier.nama as nama_supplier')
    //                     ->where('pemesanan.id', '=', $id)
    //                     ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
    //                     ->get();

    //     $detail_pemesanan = DB::table('detail_back_order')
    //                             ->select('detail_back_order.*', 'back_order.pemesanan_id', 'barang.id', 'barang.kode', 'barang.nama', 'barang.harga_jual')
    //                             ->where('back_order.pemesanan_id', '=', $id)
    //                             ->join('barang', 'detail_back_order.barang_id', '=', 'barang.id')
    //                             ->join('back_order', 'detail_back_order.back_order_id', '=', 'back_order.id')
    //                             ->whereRaw('detail_back_order.back_order_id = (select max(`back_order_id`) from detail_back_order)')
    //                             ->get(); 

    //     return view('admin.penerimaan_pesanan.proses_terima', ['pemesanan' => $pemesanan, 'detail_pemesanan' => $detail_pemesanan]);

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        $status_bayar = $request->uang_muka > 0 ? "Lunas sebagian" : "Belum lunas";

        $penerimaan_pesanan_id = DB::table('penerimaan_pemesanan')
                                        ->insertGetId([
                                            'pemesanan_id' => $request->pemesanan_id,
                                            'tanggal' => $request->tanggal_terima,
                                            'users_id' => auth()->user()->id
                                        ]);

        $pembelian_id = DB::table('pembelian')
                        ->insertGetId([
                            'nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => $request->tanggal_terima,
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'ongkos_kirim' => $request->ongkos_kirim,
                            'metode_pembayaran' => $request->metode_pembayaran,
                            'status_bayar' => $status_bayar,
                            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                            'sisa_belum_bayar' => $request->sisa_belum_bayar,
                            'total' => $request->total,
                            'status_retur' => 'Tidak ada retur',
                            'uang_muka' => $request->uang_muka,
                            'total_terbayar' => $request->total_terbayar,
                            'users_id' => auth()->user()->id
                        ]);
                                        
        $barang_diterima = json_decode($request->barang_diterima, true);

        $totalHargaBarangDiterima = 0;

        $totalHargaBarangTidakDiterima = 0;

        $status = "";

        for($i = 0; $i < count($barang_diterima); $i++)
        {
            $totalHargaBarangDiterima += $barang_diterima[$i]['subtotal'];

            $insertDetailPenerimaan = DB::table('detail_penerimaan_pemesanan')
                                        ->insert([
                                            'pemesanan_id' => $request->pemesanan_id,
                                            'barang_id' => $barang_diterima[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $barang_diterima[$i]['tanggal_kadaluarsa'],
                                            'harga_pesan' => $barang_diterima[$i]['harga_pesan'],
                                            'jumlah_pesan' => $barang_diterima[$i]['kuantitas_pesan'],
                                            'jumlah_terima' => $barang_diterima[$i]['kuantitas_terima'],
                                            'subtotal' => $barang_diterima[$i]['subtotal']
                                        ]);

            $insertDetailPembelian = DB::table('detail_pembelian')
                                        ->insert([
                                            'pembelian_id' => $pembelian_id,
                                            'barang_id' => $barang_diterima[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $barang_diterima[$i]['tanggal_kadaluarsa'],
                                            'kuantitas' => $barang_diterima[$i]['kuantitas_terima'],
                                            'diskon_potongan_harga' => 0,
                                            'harga_beli' => $barang_diterima[$i]['harga_pesan'],
                                            'subtotal' => $barang_diterima[$i]['subtotal']
                                        ]);

            $cariBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $barang_diterima[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $barang_diterima[$i]['tanggal_kadaluarsa'])
                            ->get();
            
            if(count($cariBarang) > 0)
            {
                $updateBarang = DB::table('barang_has_kadaluarsa')
                                ->where('id', '=', $cariBarang[0]->id)
                                ->increment('jumlah_stok_di_gudang', $barang_diterima[$i]['kuantitas_terima']);
            }
            else 
            {
                $insertBarang = DB::table('barang_has_kadaluarsa')
                                ->insert([
                                    'barang_id' => $barang_diterima[$i]['barang_id'],
                                    'tanggal_kadaluarsa' => $barang_diterima[$i]['tanggal_kadaluarsa'],
                                    'jumlah_stok_di_gudang' => $barang_diterima[$i]['kuantitas_terima']
                                ]);
            }
            
        }

        $update_pemesanan = DB::table('pemesanan')
                             ->where('id', '=', $request->pemesanan_id)
                             ->update([
                                'status' => 'Telah diterima di gudang',
                                'total' => $totalHargaBarangDiterima
                             ]);
    
        return redirect()->route('penerimaan_pesanan.index')->with(['success' => 'Data berhasil diproses']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.nomor_nota', 'pemesanan.tanggal', 'supplier.id as supplier_id', 'supplier.nama as nama_pemasok')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('pemesanan.id', '=', $id)
                        ->get();
         
        $detail_penerimaan_pesanan = DB::table('detail_penerimaan_pemesanan')
                                        ->select('detail_penerimaan_pemesanan.*', 'barang.kode', 'barang.nama')
                                        ->where('detail_penerimaan_pemesanan.pemesanan_id', '=', $id)
                                        ->join('barang', 'detail_penerimaan_pemesanan.barang_id', '=', 'barang.id')
                                        ->get();

        $penerimaan_pesanan = DB::table('penerimaan_pemesanan')
                                ->where('id', '=', $id)
                                ->get();

        return view('admin.penerimaan_pesanan.lihat', ['pemesanan' => $pemesanan, 'detail_penerimaan_pesanan' => $detail_penerimaan_pesanan, 'penerimaan_pesanan' => $penerimaan_pesanan]);
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
