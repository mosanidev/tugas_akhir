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
                                'total' => $request->total
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
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier', 'users.nama_depan as nama_depan', 'users.nama_belakang as nama_belakang')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->join('users', 'pembelian.users_id', '=', 'users.id')->where('pembelian.id', '=', $id)->get();
        
        $detailPembelian = DB::table('detail_pembelian')->select('detail_pembelian.*', 'barang.id as barang_id', 'barang.nama as nama_barang')->join('barang', 'detail_pembelian.barang_id', '=', 'barang.id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

        $barangDibeli = DB::table('barang')->select('barang.id')->where('barang_konsinyasi', '=', 0)->join('detail_pembelian', 'barang.id', '=', 'detail_pembelian.barang_id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

        $arrIdBarang = array();

        $total = 0;
        for($i = 0; $i < count($barangDibeli); $i++)
        {
            $total += $detailPembelian[$i]->subtotal;
            array_push($arrIdBarang, $barangDibeli[$i]->id);
        }

        //update agak lama
        $updatePembelian = DB::table('pembelian')->where('pembelian.id', $id)->update(['total' => $total]);

        $barang = DB::table('barang')->select('barang.id', 'barang.kode', 'barang.nama')->whereNotin('id', $arrIdBarang)->get();        

        if($request->ajax())
        {
            return response()->json(['pembelian'=>$pembelian]);
        }
        else
        {
            return view('admin.pembelian.barang_dibeli.index', ['pembelian'=>$pembelian, 'detailPembelian' => $detailPembelian, 'barang'=>$barang]);
        }

    }

    public function changeDraftToComplete ($id)
    {
        $update = DB::table('pembelian')
                    ->where('id', $id)
                    ->update(['status' => 'Complete']);

        return redirect()->route('pembelian.index')->with(['success'=>'Data pembelian berhasil dikonfirmasi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = DB::table('supplier')->get();
        $barang = DB::table('barang')->get();
        $pembelian = DB::table('pembelian')->select('pembelian.*', 'supplier.nama as nama_supplier')->join('supplier', 'pembelian.supplier_id', '=', 'supplier.id')->where('pembelian.id', '=', $id)->get();
        $detail_pembelian = DB::table('detail_pembelian')->select('detail_pembelian.*', 'barang.nama as nama_barang')->join('barang', 'detail_pembelian.barang_id', '=', 'barang.id')->where('detail_pembelian.pembelian_id', '=', $id)->get();

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
        $update = DB::table('pembelian')->where('id', $id)->update(['nomor_nota' => $request->nomor_nota, 'tanggal'=>$request->tanggalBuat, 'tanggal_jatuh_tempo'=> $request->tanggalJatuhTempo, 'metode_pembayaran' => $request->metodePembayaran, 'diskon' => $request->diskon, 'status' => $request->status, 'ppn' => $request->ppn, 'supplier_id'=>$request->supplier_id]);
        
        return redirect()->back()->with(['status'=>'Berhasil ubah data']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DB::table('pembelian')->where('id', '=', $id)->delete();

        return redirect()->route('pembelian.index')->with(['status'=>'Hapus data berhasil']);

    }
}
