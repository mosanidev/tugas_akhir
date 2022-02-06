<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ReturPenjualanController extends Controller
{
    public function showForm()
    {
        $kategori = DB::table('kategori_barang')->get();
        $barang = DB::table('barang')->get();
        // $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['barang' => $barang, 'retur_penjualan' => true, 'semua_kategori' => $kategori, 'total_cart' => $total_cart]);
    }

    public function store(Request $request)
    {
        dd($request);
        $detailReturPenjualan = json_decode($request->arrBarangDitukar);
        
        $tanggal = $request->tanggal;
        
        $nomorNota = $request->nomor_nota;

        $linkFile = $request->link_file;

        $selectPenjualan = DB::table('penjualan')->select('penjualan.*', 'detail_penjualan.*')->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')->where('penjualan.nomor_nota', '=', $nomorNota)->where('penjualan.users_id', '=', auth()->user()->id)->get();

        dd(\Carbon\Carbon::parse($selectPenjualan[0]->tanggal)->diffInHours(\Carbon\Carbon::now()));

        if(count($selectPenjualan) == 0)
        {
            return redirect()->back()->with(['error' => 'Nomor nota tidak ada di riwayat transaksi anda']);
        }
        else if(\Carbon\Carbon::parse($selectPenjualan[0]->tanggal)->diffInHours(\Carbon\Carbon::now()) > 72) // cek selisih jam antara sekarang dan tanggal transaksi
        {
            return redirect()->back()->with(['error' => 'Transaksi anda tidak sesuai dengan ketentuan karena lebih dari 3 hari yang lalu']);
        }
        // jika penjualan lebih dari 3 hari yang lalu

        // jika penjualan belum sampai ke konsumen
        
        // jika barang di penjualan tidak sesuai dengan pengajuan retur

        // jika jumlah barang yang di retur melebihi yang dibeli

        $idReturPenjualan = DB::table('retur_penjualan')->insertGetId([
                                    'tanggal' => $tanggal,
                                    'users_id' => auth()->user()->id,
                                    'penjualan_id' => $selectPenjualan[0]->id,
                                    'status' => 'Menunggu pengajuan dicek admin',
                                    'link' => $linkFile
        ]);


        // $insertDetailPenjualan = DB::table('detail_retur_penjualan')->insert([
        //                                 'retur_penjualan_id' => $idReturPenjualan,
        //                                 'barang_id' => 
        // ]);
    }
}
