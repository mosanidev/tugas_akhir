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
                        
        return view('admin.pembelian.index', ['pembelian'=>$pembelian, 'supplier'=>$supplier, 'nomor_nota'=>$nomorNota]);
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
        $idPembelian = DB::table('pembelian')
                        ->insertGetId([
                            'id' => $request->id,
                            'nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => \Carbon\Carbon::parse($request->tanggalBuat)->format('Y-m-d'),
                            'metode_pembayaran' => $request->metodePembayaran,
                            'status_bayar' => 'Belum lunas',
                            'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggalJatuhTempo)->format('Y-m-d')
                        ]);

        return redirect()->route('pembelian.addBarang', ['pembelian'=>$idPembelian])->with(['success' => 'Data pembelian berhasil ditambah']);
    }

    public function addBarang($id)
    {
        $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 'supplier.nama as nama_supplier')
                        ->where('pembelian.id', '=', $id)
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->get();

        $barang = DB::table('barang')
                    ->where('supplier_id', '=', $pembelian[0]->supplier_id)
                    ->get(); 

        return view('admin.pembelian.tambah_barang_dibeli',['pembelian' => $pembelian, 'barang'=> $barang]);
    }

    public function storeFull(Request $request)
    {
        $dataBarang = json_decode($request->barang, true);
        $total = 0;

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
                $addStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok', $dataBarang[$i]['kuantitas']);  

            }

            $insertDetailPembelian = DB::table('detail_pembelian')
                                            ->insert([
                                                'pembelian_id'          => $request->id,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'kuantitas'             => $dataBarang[$i]['kuantitas'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'harga_beli'            => $dataBarang[$i]['harga_beli'],
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

            $total += $dataBarang[$i]['subtotal'];

        }

        $updatePembelian = DB::table('pembelian')
                            ->where('id', '=', $request->id)
                            ->update([
                                'total' => $total
                            ]);

        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil ditambah']);
    }


    public function storeOld(Request $request)
    {
        $idPembelian = DB::table('pembelian')
                        ->insertGetId([
                            'id' => $request->id,
                            'nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier,
                            'supplier_id' => $request->supplier_id,
                            'tanggal' => \Carbon\Carbon::parse($request->tanggalBuat)->format('Y-m-d'),
                            'diskon' => $request->diskon,
                            'ppn' => $request->ppn,
                            'metode_pembayaran' => $request->metodePembayaran,
                            'status_bayar' => 'Belum lunas',
                            'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggalJatuhTempo)->format('Y-m-d'),
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
                $addStokBarang = DB::table('barang_has_kadaluarsa')
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
                                                'diskon_potongan_harga' => $dataBarang[$i]['diskon_potongan_harga'],
                                                'subtotal'              => $dataBarang[$i]['subtotal']
                                            ]);

        }

        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        $dataPembelian = DB::table('pembelian')
                        ->select('pembelian.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->where('pembelian.id', $id)
                        ->get();

        if($dataPembelian[0]->status_retur == "Ada retur")
        {
            $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 
                                 'supplier.nama as nama_supplier', 
                                 'retur_pembelian.id as retur_pembelian_id', 
                                 'retur_pembelian.nomor_nota as nomor_nota_retur',
                                 'retur_pembelian.total as total_retur')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->where('pembelian.id', $id)
                        ->join('retur_pembelian', 'pembelian.id', '=', 'retur_pembelian.pembelian_id')
                        ->get();
        }
        else 
        {
            $pembelian = DB::table('pembelian')
                        ->select('pembelian.*', 
                                 'supplier.nama as nama_supplier')
                        ->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')
                        ->where('pembelian.id', $id)
                        ->get();
        }

        $detailPembelian = DB::table('detail_pembelian')
                            ->select('barang.kode', 
                                     'barang.nama', 
                                     'detail_pembelian.tanggal_kadaluarsa', 
                                     'detail_pembelian.harga_beli', 
                                     'detail_pembelian.diskon_potongan_harga', 
                                     'detail_pembelian.kuantitas', 
                                     'detail_pembelian.subtotal',
                                     'barang.barang_konsinyasi')
                            ->where('pembelian.id', $id)
                            ->join('pembelian', 'pembelian.id', '=', 'detail_pembelian.pembelian_id')
                            ->join('barang', 'barang.id', '=', 'detail_pembelian.barang_id')
                            ->get();

        if($request->ajax())
        {
            return response()->json(['pembelian' => $pembelian]);
        }
        else 
        {
            return view('admin.pembelian.lihat', ['pembelian' => $pembelian, 'detail_pembelian' => $detailPembelian]);
        }

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
        $barang = DB::table('barang')
                    ->where('barang_konsinyasi', '=', 0)
                    ->where('supplier_id', '=', $pembelian[0]->supplier_id)
                    ->get();
                    
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

        for($i = 0; $i < count($detailPembelian); $i++)
        {
            $stok = DB::table('barang_has_kadaluarsa')
                            ->select('jumlah_stok')
                            ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                            ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                            ->get();

            $qtyStok = $stok[0]->jumlah_stok;

            if($qtyStok-$detailPembelian[$i]->kuantitas < 0)
            {
                $ubahStok = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                                ->update([
                                    'jumlah_stok' => 0
                                ]);    
            }
            else 
            {
                $kurangiStok = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailPembelian[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailPembelian[$i]->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok', $detailPembelian[$i]->kuantitas);
            }
        }
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

        $deleteDetailPembelian = DB::table('detail_pembelian')
                                        ->where('pembelian_id', '=', $id)
                                        ->delete();

        $update = DB::table('pembelian')
                        ->where('id', $id)
                        ->update(['nomor_nota_dari_supplier' => $request->nomor_nota_dari_supplier, 
                                  'tanggal'=> \Carbon\Carbon::parse($request->tanggal_buat)->format('Y-m-d'), 
                                  'tanggal_jatuh_tempo'=> \Carbon\Carbon::parse($request->tanggal_jatuh_tempo)->format('Y-m-d'), 
                                  'metode_pembayaran' => $request->metode_pembayaran,
                                  'diskon' => $request->diskon,             
                                  'ppn' => $request->ppn, 
                                  'status_bayar' => 'Belum lunas',
                                  'total' => $request->total
                                ]);

        $dataBarang = json_decode($request->barang, true);

        for ($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $tglKadaluarsa = $dataBarang[$i]['tanggal_kadaluarsa'] != "Tidak ada" ? $dataBarang[$i]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

            $selectBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
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
                $addStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok', $dataBarang[$i]['kuantitas']);  

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
        
        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil diubah']);
    }

    public function lunasi(Request $request, $id)
    {
        $lunasi = DB::table('pembelian')
                    ->where('id', '=', $id)
                    ->update([
                        'status_bayar' => 'Sudah lunas',
                        'tanggal_pelunasan' => \Carbon\Carbon::parse($request->tanggal_pelunasan)->format('Y-m-d')
                    ]);

        return redirect()->back()->with(['success' => 'Pembelian berhasil dilunasi']);
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
