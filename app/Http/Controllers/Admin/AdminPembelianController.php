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
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->get();
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
        $supplier = DB::table('supplier')->where('jenis', '=', 'Perusahaan')->get();
        $barang = DB::table('barang')->where('barang_konsinyasi', '=', 0)->get();

        return view('admin.pembelian.tambah', ['supplier'=>$supplier, 'barang'=>$barang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idPembelian = DB::table('pembelian')
                            ->insertGetId([
                                'nomor_nota' => $request->nomor_nota,
                                'supplier_id' => $request->supplier_id,
                                'tanggal' => $request->tanggalBuat,
                                'tanggal_jatuh_tempo' => $request->tanggalJatuhTempo,
                                'diskon' => $request->diskon,
                                'ppn' => $request->ppn,
                                'metode_pembayaran' => $request->metodePembayaran,
                                'status_bayar' => $request->status,
                                'total' => $request->total,
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
                                        'jumlah_stok' => $dataBarang[$i]['kuantitas']
                                    ]);
                 
            }
            else // jika ada barang yang sama maka tambah kuantitas
            {
                $insertStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok', $dataBarang[$i]['kuantitas']);  

            }

            $insertDetailPembelian = DB::table('detail_pembelian')
                                            ->insert([
                                                'pembelian_id'          => $idPembelian,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'harga_beli'            => $dataBarang[$i]['harga_beli'],
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
                            ->select('barang.kode', 'barang.nama', 'detail_pembelian.tanggal_kadaluarsa', 'detail_pembelian.harga_beli', 'detail_pembelian.kuantitas', 'detail_pembelian.subtotal')
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
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->where('pembelian.id', '=', $id)->get();
        
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
                                     'detail_pembelian.kuantitas',
                                     'detail_pembelian.subtotal',
                                     'detail_pembelian.tanggal_kadaluarsa')
                            ->join('barang', 'detail_pembelian.barang_id', '=', 'barang.id')
                            ->where('detail_pembelian.pembelian_id', '=', $id)
                            ->get();

        return view('admin.pembelian.ubah', ['pembelian'=>$pembelian, 'detail_pembelian'=>$detail_pembelian, 'supplier'=>$supplier, 'barang'=>$barang]);
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
        $update = DB::table('pembelian')->where('id', $id)
                        ->update(['nomor_nota' => $request->nomor_nota, 
                                  'tanggal'=>$request->tanggal_buat, 
                                  'tanggal_jatuh_tempo'=> $request->tanggal_jatuh_tempo, 
                                  'metode_pembayaran' => $request->metode_pembayaran,
                                  'diskon' => $request->diskon, 
                                  'status_bayar' => $request->status_bayar, 
                                  'ppn' => $request->ppn, 
                                  'supplier_id'=>$request->supplier_id,
                                  'total' => $request->total]);

        $detailPembelian = DB::table('detail_pembelian')
                            ->where('pembelian_id', '=', $id)
                            ->get();

        $dataBarang = json_decode($request->barang, true);

        for($i = 0; $i < count(array($detailPembelian)); $i++)
        {
            for ($x = 0; $x < count((array) $dataBarang); $x++)
            {
                $tglKadaluarsa = $dataBarang[$x]['tanggal_kadaluarsa'] != "Tidak ada" ? $dataBarang[$x]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

                if($detailPembelian[$i]->barang_id == $dataBarang[$x]['barang_id'] && explode(" ", $detailPembelian[$i]->tanggal_kadaluarsa)[0] == $dataBarang[$x]['tanggal_kadaluarsa'])
                {
                    if($dataBarang[$x]['kuantitas'] < $detailPembelian[$i]->kuantitas)
                    {
                        $selisih = $detailPembelian[$i]->kuantitas - $dataBarang[$x]['kuantitas'];

                        $updateBarangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                                        ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                        ->where('tanggal_kadaluarsa', '=', $dataBarang[$x]['tanggal_kadaluarsa'])
                                                        ->decrement('jumlah_stok', $selisih);

                        $updateDetailPembelian = DB::table('detail_pembelian')
                                                    ->where('pembelian_id', '=', $id)
                                                    ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                                    ->decrement('kuantitas', $selisih);

                        $updateDetailPembelian = DB::table('detail_pembelian')
                                                    ->where('pembelian_id', '=', $id)
                                                    ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa) 
                                                    ->update([
                                                        'subtotal' => $dataBarang[$x]['subtotal']
                                                    ]);
                                                    
                    }
                    else if($dataBarang[$x]['kuantitas'] > $detailPembelian[$i]->kuantitas)
                    {
                        $selisih = $dataBarang[$x]['kuantitas'] - $detailPembelian[$i]->kuantitas;

                        $updateBarangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                                        ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                        ->where('tanggal_kadaluarsa', '=', $dataBarang[$x]['tanggal_kadaluarsa'])
                                                        ->increment('jumlah_stok', $selisih);

                        $updateDetailPembelian = DB::table('detail_pembelian')
                                                    ->where('pembelian_id', '=', $id)
                                                    ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                                    ->increment('kuantitas', $selisih);

                        $updateDetailPembelian = DB::table('detail_pembelian')
                                                    ->where('pembelian_id', '=', $id)
                                                    ->where('barang_id', '=', $dataBarang[$x]['barang_id'])
                                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                                    ->update([
                                                        'subtotal' => $dataBarang[$x]['subtotal']
                                                    ]);
                    }
                }
                else 
                {
                    $insert = DB::table('barang_has_kadaluarsa')
                                ->insert([
                                    'barang_id' => $dataBarang[$x]['barang_id'],
                                    'tanggal_kadaluarsa' => $dataBarang[$x]['tanggal_kadaluarsa'],
                                    'jumlah_stok' => $dataBarang[$x]['kuantitas']
                                ]);

                    $insertDetailPembelian = DB::table('detail_pembelian')
                                            ->insert([
                                                'pembelian_id'          => $id,
                                                'barang_id'             => $dataBarang[$x]['barang_id'],
                                                'kuantitas'             => $dataBarang[$x]['kuantitas'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'harga_beli'            => $dataBarang[$x]['harga_beli'],
                                                'subtotal'              => $dataBarang[$x]['subtotal']
                                            ]);
                }  
            }
        }
        
        return redirect()->route('pembelian.index')->with(['status'=>'Berhasil ubah data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detailPembelian = DB::table('detail_pembelian')
                            ->where('pembelian_id', '=', $id)
                            ->get();

        for($i = 0; $i < count(array($detailPembelian)); $i++)
        {
            $kurangiStok = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                            ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                            ->decrement('jumlah_stok', $detailPembelian[$i]->kuantitas);
        }

        $delete = DB::table('pembelian')->where('id', '=', $id)->delete();

        return redirect()->route('pembelian.index')->with(['status'=>'Hapus data berhasil']);

    }
}
