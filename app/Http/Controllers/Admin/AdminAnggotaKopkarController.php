<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminAnggotaKopkarController extends Controller
{
    public function indexPembelian()
    {
        return view('admin.anggota_kopkar.pembelian');
    }

    public function filterPembelian(Request $request)
    {
        $daftarAnggota = DB::table('users')
                            ->select(DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as nama"))
                            ->where('users.jenis', '=', 'Anggota_Kopkar')
                            ->where('users.status_verifikasi_anggota', '=', 'Verified')
                            ->orderBy('nama')
                            ->get();

        $anggotaBeli = DB::table('users')
                        ->select(DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as nama"), DB::raw('sum(penjualan.total) as pembelian'))
                        ->join('penjualan', 'penjualan.users_id', '=', 'users.id')
                        ->where('penjualan.status_jual', '=', 'Pesanan sudah dibayar')
                        ->where('penjualan.status_retur', '=', 'Tidak ada retur')
                        ->where('users.jenis', '=', 'Anggota_Kopkar')
                        ->whereBetween('penjualan.tanggal', [$request->filter_tanggal_awal,$request->filter_tanggal_akhir])
                        ->where('users.status_verifikasi_anggota', '=', 'Verified')
                        ->orderBy('nama')
                        ->get();

        return view('admin.anggota_kopkar.pembelian', ['anggota' => $daftarAnggota, 'anggotaBeli' => $anggotaBeli]);
    }


    public function indexHutang()
    {
        return view('admin.anggota_kopkar.hutang');
    }

    public function filterHutang(Request $request)
    {
        $daftarAnggota = DB::table('users')
                            ->select(DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as nama"))
                            ->where('users.jenis', '=', 'Anggota_Kopkar')
                            ->where('users.status_verifikasi_anggota', '=', 'Verified')
                            ->orderBy('nama')
                            ->get();

        $anggotaBeli = DB::table('users')
                        ->select(DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as nama"), DB::raw('sum(penjualan.total) as hutang'))
                        ->join('penjualan', 'penjualan.users_id', '=', 'users.id')
                        ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                        ->where('penjualan.status_jual', '=', 'Pesanan sudah dibayar')
                        ->where('users.jenis', '=', 'Anggota_Kopkar')
                        ->where('pembayaran.metode_pembayaran', '=', 'Pemotongan gaji')
                        ->where('pembayaran.status_bayar', '=', 'Belum lunas')
                        ->whereBetween('penjualan.tanggal', [$request->filter_tanggal_awal,$request->filter_tanggal_akhir])
                        ->where('users.status_verifikasi_anggota', '=', 'Verified')
                        ->orderBy('nama')
                        ->get();

        return view('admin.anggota_kopkar.hutang', ['anggota' => $daftarAnggota, 'anggotaBeli' => $anggotaBeli]);
    }

    public function show()
    {
        $daftarAnggota = DB::table('users')
                            ->where('jenis', '=', 'Anggota_Kopkar')
                            ->get();

        return view('admin.anggota_kopkar.show', ['anggota' => $daftarAnggota]);
    }
}
