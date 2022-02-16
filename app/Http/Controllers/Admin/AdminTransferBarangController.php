<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminTransferBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomorTransfer = DB::table('transfer_barang')
                            ->selectRaw('max(id) as nomor_transfer_barang')
                            ->get();

        $nomorTransfer = $nomorTransfer[0]->nomor_transfer_barang;

        if($nomorTransfer == null)
        {
            $nomorTransfer = 1;
        }
        else 
        {
            $nomorTransfer += 1;
        }

        $transferBarang = DB::table('transfer_barang')
                            ->select('transfer_barang.*', 'users.nama_depan', 'users.nama_belakang')
                            ->join('users', 'transfer_barang.users_id', '=', 'users.id')
                            ->get();

        return view('admin.transfer_barang.index', ['transfer_barang' => $transferBarang, 'nomor_transfer_barang' => $nomorTransfer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.kode', 'barang.nama')
                    ->get();

        $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                    ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang', 'barang_has_kadaluarsa.jumlah_stok_di_rak')
                    ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                    ->get();

        $nomorTransfer = $nomorTransfer[0]->nomor_transfer_barang+1;

        return view('admin.transfer_barang.tambah', ['barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang, 'nomor_transfer_barang' => $nomorTransfer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idTransfer = DB::table('transfer_barang')
                    ->insertGetId([
                        'id' => $request->transfer_barang_id,
                        'tanggal' => $request->tanggal,
                        'lokasi_asal' => $request->lokasi_asal,
                        'lokasi_tujuan' => $request->lokasi_tujuan,
                        'keterangan' => $request->keterangan,
                        'users_id' => auth()->user()->id
                    ]);

        return redirect()->route('transfer_barang.storeTransferBarang', ['transfer_barang' => $idTransfer]);

        
    }

    public function storeTransferBarang($id)
    {
        $transferBarang = DB::table('transfer_barang')
                            ->select('transfer_barang.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('transfer_barang.id', $id)
                            ->join('users', 'transfer_barang.users_id', '=', 'users.id')
                            ->get();

        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.kode', 'barang.nama')
                    ->get();

        $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang', 'barang_has_kadaluarsa.jumlah_stok_di_rak')
                                ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                ->get();

        return view('admin.transfer_barang.tambah', ['transfer_barang' => $transferBarang, 'barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang])->with(['success' => 'Data transfer barang berhasil ditambah. Silahkan lengkapi barang yang ditransfer']);
    }

    public function storeDetailTransferBarang(Request $request)
    {
        $detail_transfer_barang = json_decode($request->detail_transfer_barang, true);

        foreach($detail_transfer_barang as $item)
        {
            $insertDetailTransfer = DB::table('detail_transfer_barang')
                                        ->insert([
                                            'transfer_barang_id' => $request->transfer_barang_id,
                                            'barang_id' => $item['barang_id'],
                                            'tanggal_kadaluarsa' => $item['barang_tanggal_kadaluarsa'],
                                            'kuantitas' => $item['jumlah_dipindah']
                                        ]);

            if($request->lokasi_tujuan == "Gudang") 
            {
                $update = DB::table('barang_has_kadaluarsa')
                        ->where('barang_id', '=', $item['barang_id'])
                        ->where('tanggal_kadaluarsa', '=', $item['barang_tanggal_kadaluarsa'])
                        ->update([
                            'jumlah_stok_di_rak' => DB::raw("jumlah_stok_di_rak - $item[jumlah_dipindah]"),
                            'jumlah_stok_di_gudang' => DB::raw("jumlah_stok_di_gudang + $item[jumlah_dipindah]"),
                        ]);
            }
            else 
            {
                $update = DB::table('barang_has_kadaluarsa')
                        ->where('barang_id', '=', $item['barang_id'])
                        ->where('tanggal_kadaluarsa', '=', $item['barang_tanggal_kadaluarsa'])
                        ->update([
                            'jumlah_stok_di_rak' => DB::raw("jumlah_stok_di_rak + $item[jumlah_dipindah]"),
                            'jumlah_stok_di_gudang' => DB::raw("jumlah_stok_di_gudang - $item[jumlah_dipindah]"),
                        ]);
            }
        }

        return redirect()->route('transfer_barang.index')->with(['success' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transferBarang = DB::table('transfer_barang')
                            ->where('id', $id)
                            ->get();

        $detailTransferBarang = DB::table('detail_transfer_barang')
                                    ->select('detail_transfer_barang.transfer_barang_id',
                                             'barang.kode',
                                             'barang.nama',
                                             'detail_transfer_barang.tanggal_kadaluarsa',
                                             'detail_transfer_barang.kuantitas')
                                    ->where('detail_transfer_barang.transfer_barang_id', $id)
                                    ->join('barang', 'detail_transfer_barang.barang_id', '=', 'barang.id')
                                    // ->join('barang_has_kadaluarsa', 'detail_transfer_barang.tanggal_kadaluarsa', '=', 'barang_has_kadaluarsa.tanggal_kadaluarsa')
                                    ->get();

        return view('admin.transfer_barang.lihat', ['transfer_barang' => $transferBarang, 'detail_transfer_barang' => $detailTransferBarang]);
    }

    public function tes()
    {
        // $detail_transfer_barang = json_decode($request->detail_transfer_barang, true);

        // foreach($detail_transfer_barang as $item)
        // {
        //     $insertDetailTransfer = DB::table('detail_transfer_barang')
        //                                 ->insert([
        //                                     'transfer_barang_id' => $idTransfer,
        //                                     'barang_id' => $item->barang_id,
        //                                     'tanggal_kadaluarsa' => $item->tanggal_kadaluarsa,
        //                                     'jumlah_dipindah' => $item->jumlah_dipindah
        //                                 ]);

        //     if($request->lokasi_tujuan == "Gudang") 
        //     {
        //         $update = DB::table('barang_has_kadaluarsa')
        //                 ->where('barang_id', '=', $item->barang_id)
        //                 ->where('tanggal_kadaluarsa', '=', $item->tanggal_kadaluarsa)
        //                 ->decrement('jumlah_stok_di_rak', $item->jumlah_dipindah)
        //                 ->increment('jumlah_stok_di_gudang', $item->jumlah_dipindah);
        //     }
        //     else 
        //     {
        //         $update = DB::table('barang_has_kadaluarsa')
        //                 ->where('barang_id', '=', $item->barang_id)
        //                 ->where('tanggal_kadaluarsa', '=', $item->tanggal_kadaluarsa)
        //                 ->increment('jumlah_stok_di_rak', $item->jumlah_dipindah)
        //                 ->decrement('jumlah_stok_di_gudang', $item->jumlah_dipindah);
        //     }
        // }

        // return redirect()->route('transfer_barang.index')->with(['success' => 'Data berhasil ditambah']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transferBarang = DB::table('transfer_barang')
                            ->select('transfer_barang.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('transfer_barang.id', '=', $id)
                            ->join('users', 'transfer_barang.users_id', '=', 'users.id')
                            ->get();

        return response()->json(['transfer_barang' => $transferBarang]);
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
