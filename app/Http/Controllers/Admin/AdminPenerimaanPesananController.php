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
    }

    public function prosesTerima($id)
    {
        $pemesanan = DB::table('pemesanan')
                        ->select('pemesanan.*', 'supplier.id as supplier_id', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pemesanan.supplier_id', '=', 'supplier.id')
                        ->where('pemesanan.id', '=', $id)
                        ->get();
         
        $detail_pemesanan = DB::table('detail_pemesanan')
                            ->select('detail_pemesanan.*', 'barang.id', 'barang.kode', 'barang.nama', 'barang.harga_jual', 'barang.satuan')
                            ->where('detail_pemesanan.pemesanan_id', '=', $id)
                            ->join('barang', 'detail_pemesanan.barang_id', '=', 'barang.id')
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
                                            'tanggal' => \Carbon\Carbon::parse($request->tanggal_terima)->format('Y-m-d'),
                                            'users_id' => auth()->user()->id
                                        ]);

        $pembelian_id = DB::table('pembelian')
                        ->insertGetId([
                            'nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => \Carbon\Carbon::parse($request->tanggal_terima)->format('Y-m-d'),
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'metode_pembayaran' => $request->metode_pembayaran,
                            'status_bayar' => 'Belum lunas',
                            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                            'total' => $request->total,
                            'status_retur' => 'Tidak ada retur',
                            'users_id' => auth()->user()->id
                        ]);
                                        
        $barang_diterima = json_decode($request->barang_diterima, true);

        $detail_penerimaan = json_decode($request->detail_penerimaan, true);

        $status = "";

        for($i = 0; $i < count($detail_penerimaan); $i++)
        {
            $insertDetailPenerimaan = DB::table('detail_penerimaan_pemesanan')
                                        ->insert([
                                            'pemesanan_id' => $request->pemesanan_id,
                                            'barang_id' => $detail_penerimaan[$i]['barang_id'],
                                            'jumlah_pesan' => $detail_penerimaan[$i]['kuantitas_pesan'],
                                            'jumlah_terima' => $detail_penerimaan[$i]['kuantitas_terima'],
                                            'jumlah_tidak_terima' => $detail_penerimaan[$i]['kuantitas_tidak_terima']
                                        ]);
        }

        for($x = 0; $x < count($barang_diterima); $x++)
        {

            $insertDetailPembelian = DB::table('detail_pembelian')
                                        ->insert([
                                            'pembelian_id' => $pembelian_id,
                                            'barang_id' => $barang_diterima[$x]['barang_id'],
                                            'tanggal_kadaluarsa' => $barang_diterima[$x]['tanggal_kadaluarsa'],
                                            'kuantitas' => $barang_diterima[$x]['kuantitas_terima'],
                                            'diskon_potongan_harga' => 0,
                                            'harga_beli' => $barang_diterima[$x]['harga_pesan'],
                                            'subtotal' => $barang_diterima[$x]['subtotal']
                                        ]);

            $cariBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $barang_diterima[$x]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $barang_diterima[$x]['tanggal_kadaluarsa'])
                            ->get();
            
            if(count($cariBarang) > 0)
            {
                $updateBarang = DB::table('barang_has_kadaluarsa')
                                ->where('id', '=', $cariBarang[0]->id)
                                ->increment('jumlah_stok', $barang_diterima[$x]['kuantitas_terima']);
            }
            else 
            {
                $insertBarang = DB::table('barang_has_kadaluarsa')
                                ->insert([
                                    'barang_id' => $barang_diterima[$x]['barang_id'],
                                    'tanggal_kadaluarsa' => $barang_diterima[$x]['tanggal_kadaluarsa'],
                                    'jumlah_stok' => $barang_diterima[$x]['kuantitas_terima']
                                ]);
            }
            
        }

        $update_pemesanan = DB::table('pemesanan')
                             ->where('id', '=', $request->pemesanan_id)
                             ->update([
                                'status' => 'Telah diterima di gudang',
                             ]);
    
        return redirect()->route('penerimaan_pesanan.index')->with(['success' => 'Data pemesanan berhasil diproses']);
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
                                        ->select('detail_penerimaan_pemesanan.*', 'barang.kode', 'barang.nama', 'barang.satuan')
                                        ->where('detail_penerimaan_pemesanan.pemesanan_id', '=', $id)
                                        ->join('barang', 'detail_penerimaan_pemesanan.barang_id', '=', 'barang.id')
                                        ->get();

        $penerimaan_pesanan = DB::table('penerimaan_pemesanan')
                                ->where('pemesanan_id', '=', $id)
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
