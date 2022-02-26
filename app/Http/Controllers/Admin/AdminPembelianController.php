<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->get();
                        
        $supplier = DB::table('supplier')->get();

        return view('admin.pembelian.index', ['pembelian'=>$pembelian, 'supplier'=>$supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cariNomorNota = DB::table('pembelian')
                            ->select(DB::raw('max(pembelian.id) as nomor_nota'))
                            ->get();

        $nomorNota = $cariNomorNota[0]->nomor_nota;

        if($nomorNota == null)
        {
            $nomorNota = 1;
        }
        else{
            $nomorNota += 1;
        }

        $supplier = DB::table('supplier')->where('jenis', '=', 'Perusahaan')->get();
        $barang = DB::table('barang')->where('barang_konsinyasi', '=', 0)->get();

        return view('admin.pembelian.tambah', ['supplier'=>$supplier, 'barang'=>$barang, 'nomor_nota' => $nomorNota]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status_bayar = $request->uang_muka > 0 ? "Lunas sebagian" : "Belum lunas";

        $idPembelian = DB::table('pembelian')
                        ->insertGetId([
                            'id' => $request->id,
                            'nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => $request->tanggalBuat,
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'ongkos_kirim' => $request->ongkos_kirim,
                            'metode_pembayaran' => $request->metodePembayaran,
                            'status_bayar' => $status_bayar,
                            'tanggal_jatuh_tempo' => $request->tanggalJatuhTempo,
                            'sisa_belum_bayar' => $request->sisa_belum_bayar,
                            'total' => $request->total,
                            'uang_muka' => $request->uang_muka,
                            'total_terbayar' => $request->total_terbayar,
                            'users_id' => auth()->user()->id
                        ]);

        $dataBarang = json_decode($request->barang, true);

        for ($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $tglKadaluarsa = $dataBarang[$i]['tanggal_kadaluarsa'] != "Tidak ada" ? $dataBarang[$i]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

            $selectBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['tanggal_kadaluarsa'])
                            ->get();

            if (count($selectBarang) == 0) // jika tidak ada barang yang sama maka tambah baru
            {

                $insertStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->insert([
                                        'barang_id' => $dataBarang[$i]['barang_id'],
                                        'tanggal_kadaluarsa' => $tglKadaluarsa,
                                        'jumlah_stok_di_gudang' => $dataBarang[$i]['kuantitas']
                                    ]);
                 
            }
            else // jika ada barang yang sama maka tambah kuantitas
            {
                $insertStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok_di_gudang', $dataBarang[$i]['kuantitas']);  

            }

            $insertDetailPembelian = DB::table('detail_pembelian')
                                            ->insert([
                                                'pembelian_id'          => $idPembelian,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'harga_beli'            => $dataBarang[$i]['harga_beli'],
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        return redirect()->route('pembelian.index')->with(['success'=>'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->where('pembelian.id', $id)
                        ->get();

        $detailPembelian = DB::table('detail_pembelian')
                            ->select('barang.kode', 'barang.nama', 'detail_pembelian.tanggal_kadaluarsa', 'detail_pembelian.harga_beli', 'detail_pembelian.diskon_potongan_harga', 'detail_pembelian.kuantitas', 'detail_pembelian.subtotal')
                            ->where('pembelian.id', $id)
                            ->join('pembelian', 'pembelian.id', '=', 'detail_pembelian.pembelian_id')
                            ->join('barang', 'barang.id', '=', 'detail_pembelian.barang_id')
                            ->get();

        return view('admin.pembelian.lihat', ['pembelian' => $pembelian, 'detail_pembelian' => $detailPembelian]);
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 
                                 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->where('pembelian.id', '=', $id)
                        ->get();
        
        if($pembelian[0]->status_retur == "Ada Retur")
        {
            abort(404);
        }

        $supplier = DB::table('supplier')->where('jenis', '=', 'Perusahaan')->get();
        $barang = DB::table('barang')->where('barang_konsinyasi', '=', 0)->get();
        $detail_pembelian = DB::table('detail_pembelian')
                            ->select('detail_pembelian.barang_id',
                                     'barang.kode as barang_kode',
                                     'barang.nama as barang_nama',
                                     'detail_pembelian.harga_beli',
                                     'detail_pembelian.diskon_potongan_harga',
                                     'detail_pembelian.kuantitas',
                                     'detail_pembelian.subtotal',
                                     'detail_pembelian.tanggal_kadaluarsa')
                            ->join('barang', 'detail_pembelian.barang_id', '=', 'barang.id')
                            ->where('detail_pembelian.pembelian_id', '=', $id)
                            ->get();

        return view('admin.pembelian.ubah', ['pembelian'=>$pembelian, 'detail_pembelian'=>$detail_pembelian, 'supplier'=>$supplier, 'barang'=>$barang]);
    }

    public function reset($id)
    {
        $detailPembelian = DB::table('detail_pembelian')
                            ->where('pembelian_id', '=', $id)
                            ->get();

        for($i = 0; $i < count(array($detailPembelian)); $i++)
        {
            $stokDiGudang = DB::table('barang_has_kadaluarsa')
                            ->select('jumlah_stok_di_gudang')
                            ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                            ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                            ->get();

            $stokDiRak = DB::table('barang_has_kadaluarsa')
                            ->select('jumlah_stok_di_rak')
                            ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                            ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                            ->get();

            $qtyGudang = $stokDiGudang[0]->jumlah_stok_di_gudang;

            if($detailPembelian[$i]->kuantitas > $qtyGudang)
            {
                $kurangiStokGudang = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                                ->update([
                                    'jumlah_stok_di_gudang' => 0
                                ]);
            
                $qtyGudang -= $detailPembelian[$i]->kuantitas;

                $kurangiStokRak = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                                    ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                                    ->update([
                                        'jumlah_stok_di_rak' => $qtyGudang
                                    ]);
            }
            else 
            {
                $kurangiStokGudang = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok_di_gudang', $detailPembelian[$i]->kuantitas);

            }
        }

        $deleteDetailPembelian = DB::table('detail_pembelian')
                                        ->where('pembelian_id', '=', $id)
                                        ->delete();
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
        $this->reset($id);

        $status_bayar = $request->uang_muka > 0 ? "Lunas sebagian" : "Belum lunas";

        $update = DB::table('pembelian')->where('id', $id)
                        ->update(['nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier, 
                                  'tanggal'=>$request->tanggal_buat, 
                                  'tanggal_jatuh_tempo'=> $request->tanggal_jatuh_tempo, 
                                  'metode_pembayaran' => $request->metode_pembayaran,
                                  'diskon' => $request->diskon,             
                                  'ppn' => $request->ppn, 
                                  'supplier_id'=>$request->supplier_id,
                                  'status_bayar' => $status_bayar,
                                  'total' => $request->total,
                                  'uang_muka' => $request->uang_muka,
                                  'total_terbayar' => $request->total_terbayar,]);

        $dataBarang = json_decode($request->barang, true);

        for ($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $tglKadaluarsa = $dataBarang[$i]['tanggal_kadaluarsa'] != "Tidak ada" ? $dataBarang[$i]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

            $selectBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['tanggal_kadaluarsa'])
                            ->get();

            if (count($selectBarang) == 0) // jika tidak ada barang yang sama maka tambah baru
            {

                $insertStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->insert([
                                        'barang_id' => $dataBarang[$i]['barang_id'],
                                        'tanggal_kadaluarsa' => $tglKadaluarsa,
                                        'jumlah_stok_di_gudang' => $dataBarang[$i]['kuantitas']
                                    ]);
                 
            }
            else // jika ada barang yang sama maka tambah kuantitas
            {
                $insertStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok_di_gudang', $dataBarang[$i]['kuantitas']);  

            }

            $insertDetailPembelian = DB::table('detail_pembelian')
                                            ->insert([
                                                'pembelian_id'          => $id,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'harga_beli'            => $dataBarang[$i]['harga_beli'],
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        // for($i = 0; $i < count(array($detailPembelian)); $i++)
        // {
        //     for ($x = 0; $x < count((array) $dataBarang); $x++)
        //     {
        //         $tglKadaluarsa = $dataBarang[$x]['tanggal_kadaluarsa'] != "Tidak ada" ? $dataBarang[$x]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

        //         if($detailPembelian[$i]->barang_id == $dataBarang[$x]['barang_id'] && explode(" ", $detailPembelian[$i]->tanggal_kadaluarsa)[0] == $dataBarang[$x]['tanggal_kadaluarsa'])
        //         {
        //             if($dataBarang[$x]['kuantitas'] < $detailPembelian[$i]->kuantitas)
        //             {
        //                 $selisih = $detailPembelian[$i]->kuantitas - $dataBarang[$x]['kuantitas'];

        //                 $updateBarangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
        //                                                 ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                                 ->where('tanggal_kadaluarsa', '=', $dataBarang[$x]['tanggal_kadaluarsa'])
        //                                                 ->decrement('jumlah_stok', $selisih);

        //                 $updateDetailPembelian = DB::table('detail_pembelian')
        //                                             ->where('pembelian_id', '=', $id)
        //                                             ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                             ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
        //                                             ->decrement('kuantitas', $selisih);

        //                 $updateDetailPembelian = DB::table('detail_pembelian')
        //                                             ->where('pembelian_id', '=', $id)
        //                                             ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                             ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa) 
        //                                             ->update([
        //                                                 'subtotal' => $dataBarang[$x]['subtotal']
        //                                             ]);
                                                    
        //             }
        //             else if($dataBarang[$x]['kuantitas'] > $detailPembelian[$i]->kuantitas)
        //             {
        //                 $selisih = $dataBarang[$x]['kuantitas'] - $detailPembelian[$i]->kuantitas;

        //                 $updateBarangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
        //                                                 ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                                 ->where('tanggal_kadaluarsa', '=', $dataBarang[$x]['tanggal_kadaluarsa'])
        //                                                 ->increment('jumlah_stok', $selisih);

        //                 $updateDetailPembelian = DB::table('detail_pembelian')
        //                                             ->where('pembelian_id', '=', $id)
        //                                             ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                             ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
        //                                             ->increment('kuantitas', $selisih);

        //                 $updateDetailPembelian = DB::table('detail_pembelian')
        //                                             ->where('pembelian_id', '=', $id)
        //                                             ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
        //                                             ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
        //                                             ->update([
        //                                                 'subtotal' => $dataBarang[$x]['subtotal']
        //                                             ]);
        //             }
        //         }
        //         else 
        //         {
        //             $insert = DB::table('barang_has_kadaluarsa')
        //                         ->insert([
        //                             'barang_id' => $dataBarang[$x]['barang_id'],
        //                             'tanggal_kadaluarsa' => $dataBarang[$x]['tanggal_kadaluarsa'],
        //                             'jumlah_stok' => $dataBarang[$x]['kuantitas']
        //                         ]);

        //             $insertDetailPembelian = DB::table('detail_pembelian')
        //                                     ->insert([
        //                                         'pembelian_id'          => $id,
        //                                         'barang_id'             => $dataBarang[$x]['barang_id'],
        //                                         'kuantitas'             => $dataBarang[$x]['kuantitas'],
        //                                         'tanggal_kadaluarsa'    => $tglKadaluarsa,
        //                                         'harga_beli'            => $dataBarang[$x]['harga_beli'],
        //                                         'subtotal'              => $dataBarang[$x]['subtotal']
        //                                     ]);
        //         }  
        //     }
        // }
        
        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->reset($id);

        $delete = DB::table('pembelian')->where('id', '=', $id)->delete();

        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil dihapus']);

    }
}
