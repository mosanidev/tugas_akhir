<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminHomeController extends Controller
{
    public function index()
    {   
        // $hariIni = \Carbon\CarbonImmutable::now()->locale('id_ID');

        $menunggu_pembayaran = DB::table('penjualan')
                                ->where('status_jual', '=', 'Menunggu pesanan dibayarkan')
                                ->get();

        $sudah_dibayar = DB::table('penjualan')
                            ->where('status_jual', '=', 'Pesanan sudah dibayar')
                            ->get();

        $pembayaran_kadaluarsa = DB::table('penjualan')
                                    ->where('status_jual', '=', 'Pembayaran pesanan melebihi batas waktu yang ditentukan')
                                    ->get();

        $pengajuan_retur_perlu_dicek = DB::table('retur_penjualan')
                                            ->where('status', '=', 'Menunggu pengajuan dicek admin')
                                            ->get();

        $transaksi_penjualan_selesai = DB::table('penjualan')
                                        ->where('status_jual', '=', 'Pesanan sudah selesai')
                                        ->get();

        $pembayaran_gagal = DB::table('penjualan')
                                ->where('status_jual', '=', 'Pembayaran pesanan gagal diproses')
                                ->get();

        return view("admin.dashboard", ['menunggu_pembayaran' => count($menunggu_pembayaran), 'sudah_dibayar' => count($sudah_dibayar), 'pembayaran_kadaluarsa' => count($pembayaran_kadaluarsa), 'pengajuan_retur_perlu_dicek' => count($pengajuan_retur_perlu_dicek), 'transaksi_penjualan_selesai' => count($transaksi_penjualan_selesai), 'pembayaran_gagal' => count($pembayaran_gagal)]);
    }
}
