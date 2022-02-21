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

    public function prosesTerimaSebagian($id)
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.nama as nama_supplier')
                        ->where('pemesanan.id', '=', $id)
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->get();

        $detail_pemesanan = DB::table('detail_back_order')
                                ->select('detail_back_order.*', 'back_order.pemesanan_id', 'barang.id', 'barang.kode', 'barang.nama', 'barang.harga_jual')
                                ->where('back_order.pemesanan_id', '=', $id)
                                ->join('barang', 'detail_back_order.barang_id', '=', 'barang.id')
                                ->join('back_order', 'detail_back_order.back_order_id', '=', 'back_order.id')
                                ->whereRaw('detail_back_order.back_order_id = (select max(`back_order_id`) from detail_back_order)')
                                ->get(); 

        return view('admin.penerimaan_pesanan.proses_terima', ['pemesanan' => $pemesanan, 'detail_pemesanan' => $detail_pemesanan]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penerimaan_pesanan_id = DB::table('penerimaan_pemesanan')
                                        ->insertGetId([
                                            'pemesanan_id' => $request->pemesanan_id,
                                            'tanggal' => $request->tanggal_terima
                                        ]);

        $pembelian_id = DB::table('pembelian')
                        ->insertGetId([
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => $request->tanggal_terima,
                            'users_id' => auth()->user()->id,
                            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'metode_pembayaran' => $request->metode_pembayaran,
                            'status_bayar' => $request->status_bayar,
                            'status_retur' => 'Tidak ada retur',
                            'total' => $request->total
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

            $insertBarang = DB::table('barang_has_kadaluarsa')
                                ->insert([
                                    'barang_id' => $barang_diterima[$i]['barang_id'],
                                    'tanggal_kadaluarsa' => $barang_diterima[$i]['tanggal_kadaluarsa'],
                                    'jumlah_stok_di_gudang' => $barang_diterima[$i]['kuantitas_terima']
                                ]);
        }

        $barang_tidak_diterima = json_decode($request->barang_tidak_diterima, true);

        $jumlahBarangTidakDiterima = count(array_filter($barang_tidak_diterima, function($x) { return !empty($x); }));

        if($jumlahBarangTidakDiterima > 0)
        {
            $status = "Telah diterima sebagian";

            $back_order_id = DB::table('back_order')
                                ->insertGetId([
                                    'pemesanan_id' => $request->pemesanan_id,
                                    'tanggal' => $request->tanggal_terima
                                ]);

            for($i = 0; $i < count($barang_tidak_diterima); $i++)
            {
                if($barang_tidak_diterima[$i] != null)
                {
                    $totalHargaBarangTidakDiterima += $barang_tidak_diterima[$i]['subtotal'];

                    $insertDetailBackOrder = DB::table('detail_back_order')
                                                ->insert([
                                                    'back_order_id' => $back_order_id,
                                                    'barang_id' => $barang_tidak_diterima[$i]['barang_id'],
                                                    'harga_pesan' => $barang_tidak_diterima[$i]['harga_pesan'],
                                                    'kuantitas' => $barang_tidak_diterima[$i]['kuantitas'],
                                                    'subtotal' => $barang_tidak_diterima[$i]['kuantitas']*$barang_tidak_diterima[$i]['harga_pesan']
                                                ]);
                }
            }        
            
            $update_back_order = DB::table('back_order')
                                    ->where('id', '=', $back_order_id)
                                    ->update([
                                        'total' => $totalHargaBarangTidakDiterima
                                    ]);
        }
        else 
        {
            $status = "Telah diterima semua";
        }

        $update_pemesanan = DB::table('pemesanan')
                             ->where('id', '=', $request->pemesanan_id)
                             ->update([
                                'status' => $status,
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
