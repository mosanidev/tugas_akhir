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

    public function showHistory()
    {
        $kategori = DB::table('kategori_barang')->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();
        $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
        $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();

        $riwayat_retur = DB::table('retur_penjualan')
                            ->select('retur_penjualan.*', 'penjualan.nomor_nota')
                            ->where('retur_penjualan.users_id', '=', auth()->user()->id)
                            ->join('penjualan', 'penjualan.id', '=', 'retur_penjualan.penjualan_id')
                            ->get();

        return view('pelanggan.user_menu.user_menu', ['riwayat_retur' => $riwayat_retur, 'semua_kategori' => $kategori, 'total_cart' => $total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);

    }

    public function simpanNomorRekeningRetur(Request $request)
    {
        $IDNoRekening = DB::table('rekening_retur')
                                ->insertGetId([
                                    'bank' => $request->bank,
                                    'nama_pemilik_rekening' => strtoupper($request->nama_pemilik_rekening),
                                    'nomor_rekening' => $request->nomor_rekening
                                ]);

        $updateReturPenjualan = DB::table('retur_penjualan')
                                    ->where('id', '=', $request->retur_penjualan_id)
                                    ->update([
                                        'status' => 'Harap tunggu pengembalian dana dari admin',
                                        'rekening_retur_id' => $IDNoRekening
                                    ]);

        return redirect()->route('returPenjualan.showHistory')->with(['success' => 'Nomor rekening berhasil disimpan']);
    }

    public function store(Request $request)
    {
        $barang_diretur = json_decode($request->arrBarangDiretur);
        
        $tanggal = $request->tanggal;
        
        $nomorNota = $request->nomor_nota;

        $linkFile = $request->link_file;

        $selectPenjualan = DB::table('penjualan')
                            ->select('penjualan.*', 'detail_penjualan.*')
                            ->join('detail_penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                            ->where('penjualan.nomor_nota', '=', $nomorNota)
                            ->where('penjualan.users_id', '=', auth()->user()->id)
                            ->get();

        if(count($selectPenjualan) == 0)
        {
            return redirect()->back()->with(['error' => 'Pengajuan retur ditolak. Nomor nota tidak ada di riwayat transaksi anda']);
        }
        else if($selectPenjualan[0]->status_jual != "Pesanan sudah selesai")
        {
            return redirect()->back()->with(['error' => 'Pengajuan retur ditolak. Penjualan tersebut tidak dapat diretur, karena status penjualan belum selesai']);
        }
        else if(\Carbon\Carbon::parse($selectPenjualan[0]->tanggal)->diffInHours(\Carbon\Carbon::now()) > 72) // cek selisih jam antara sekarang dan tanggal transaksi
        {
            return redirect()->back()->with(['error' => 'Pengajuan retur ditolak. Transaksi anda tidak sesuai dengan ketentuan retur karena lebih dari 3 hari yang lalu']);
        }

        // jika penjualan lebih dari 3 hari yang lalu

        // jika penjualan belum sampai ke konsumen
        
        // jika barang di penjualan tidak sesuai dengan pengajuan retur

        // jika jumlah barang yang di retur melebihi yang dibeli

        $total = 0;

        $idReturPenjualan = DB::table('retur_penjualan')->insertGetId([
                                    'tanggal' => $tanggal,
                                    'users_id' => auth()->user()->id,
                                    'penjualan_id' => $selectPenjualan[0]->id,
                                    'status' => 'Menunggu pengajuan dicek admin',
                                    'link' => $linkFile
        ]);

        $updatePenjualan = DB::table('penjualan')
                            ->where('nomor_nota', '=', $nomorNota)
                            ->update([
                                'status_retur' => 'Ada Retur'
                            ]);

        $notifikasi = DB::table('notifikasi')
                            ->insert([
                                'users_id' => auth()->user()->id,
                                'isi' => "Pengajuan retur berhasil dibuat berdasarkan penjualan dengan nomor nota #".strtoupper($nomorNota),
                                'status' => 'Belum dilihat',
                                'penjualan_id' => $selectPenjualan[0]->id,
                                'created_at' => \Carbon\Carbon::now(),
                                'updated_at' => \Carbon\Carbon::now(),
                            ]);

        for($i = 0; $i < count($barang_diretur); $i++)
        {
            $detailPenjualan = DB::table('detail_penjualan')
                            ->where('detail_penjualan.penjualan_id', '=', $selectPenjualan[0]->id)
                            ->where('barang_id', '=', $barang_diretur[$i]->barang_id)
                            ->get();

            $hargaJual = $detailPenjualan[0]->subtotal / $detailPenjualan[0]->kuantitas;
            
            $total = $hargaJual*$barang_diretur[$i]->kuantitas;

            $insertDetailPenjualan = DB::table('detail_retur_penjualan')->insert([
                                        'retur_penjualan_id' => $idReturPenjualan,
                                        'barang_id' => $barang_diretur[$i]->barang_id,
                                        'kuantitas' => $barang_diretur[$i]->kuantitas,
                                        'subtotal' => $hargaJual*$barang_diretur[$i]->kuantitas,
                                        'alasan_retur' => $barang_diretur[$i]->alasan_retur,
                                    ]);
        }

        $updateReturPenjualan = DB::table('retur_penjualan')
                                    ->where('id', '=', $idReturPenjualan)
                                    ->update([
                                        'total' => $total
                                    ]);

        return redirect()->back()->with(['success' => 'Pengajuan retur berhasil disimpan']);
        
    }
}
