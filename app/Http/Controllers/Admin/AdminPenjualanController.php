<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use SSP;

class AdminPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = DB::table('penjualan')
                        ->select('penjualan.*', 'detail_penjualan.*', 'pembayaran.*', 'users.*', 'penjualan.status_jual as status_jual', 'pembayaran.status_bayar as status_bayar')
                        // ->where('penjualan.jenis', '=', 'Online')
                        ->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                        ->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')
                        ->join('users', 'penjualan.users_id', '=', 'users.id')
                        ->groupBy('penjualan.id')
                        ->orderBy('penjualan.tanggal', 'desc')
                        ->get();


        return view('admin.penjualan.index', ['penjualan'=>$penjualan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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

    public function filter(Request $request)
    {
        $metode_transaksi = $request->metode_transaksi;

        if ($request->ajax()) {
            $data = DB::table('penjualan')
                        ->where('metode_transaksi', '=', $metode_transaksi)
                        ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
       
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.penjualan.index');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $penjualan = DB::table('penjualan')
                        ->select('penjualan.*', 'pembayaran.*', 'users.*', 'penjualan.id as penjualan_id', 'penjualan.status_jual as status_jual', 'pembayaran.status_bayar as status_bayar')
                        ->join('pembayaran', 'pembayaran.id', '=', 'penjualan.pembayaran_id')
                        ->join('users', 'penjualan.users_id', '=', 'users.id')
                        ->where('penjualan.id', '=', $id)
                        ->groupBy('penjualan.id')
                        ->get();

        $detail_penjualan = DB::table('detail_penjualan')
                                ->select('detail_penjualan.*', 'barang.*')
                                ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                                ->where('detail_penjualan.penjualan_id', '=', $id)->get();
    
        if($request->ajax())
        {
            return response()->json(['penjualan' => $penjualan, 'detail_penjualan' => $detail_penjualan]);
        }
        else 
        {
            return view('admin.penjualan.lihat', ['penjualan'=>$penjualan, 'detail_penjualan'=>$detail_penjualan]);
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
        $update = DB::table('penjualan')
                    ->where('id', '=', $id)
                    ->update([
                        'status_jual' => $request->status_penjualan
                    ]);

        $penjualan = DB::table('penjualan')
                        ->select('penjualan.nomor_nota')
                        ->where('penjualan.id', '=', $id)
                        ->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                        ->get();

        if($request->status_penjualan == "Pesanan siap diambil di toko")
        {
            $updateNotif = DB::table('notifikasi')
                            ->where('penjualan_id', '=', $id)
                            ->update([
                                'isi' => "Pesanan #".$penjualan[0]->nomor_nota." sudah bisa diambil di toko",
                                'status' => 'Belum dilihat',
                                'updated_at' => \Carbon\Carbon::now()
                            ]);
        }
        else if($request->status_penjualan == "Pesanan sudah selesai")
        {
            $updateNotif = DB::table('notifikasi')
                            ->where('penjualan_id', '=', $id)
                            ->update([
                                'isi' => "Pesanan #".$penjualan[0]->nomor_nota." selesai diambil",
                                'status' => 'Belum dilihat',
                                'updated_at' => \Carbon\Carbon::now()
                            ]);

            $detailPenjualan = DB::table('detail_penjualan')
                                ->where('penjualan_id', '=', $id)
                                ->get();

            foreach($detailPenjualan as $item)
            {
                $kurangiStok = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $item->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $item->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok', $item->kuantitas);
            }

        }

        return redirect()->back()->with(['success' => 'Status penjualan berhasil diubah']);
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
