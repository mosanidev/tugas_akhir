<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminPenjualanOfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualanOffline = DB::table('penjualan')
                                ->select('penjualan.*', 'pembayaran.metode_pembayaran as metode_pembayaran')
                                ->where('jenis', '=', 'Offline')
                                ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                                ->get();

        return view ('admin.penjualan_offline.index', ['penjualan'=>$penjualanOffline]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $oneWeekLater = \Carbon\Carbon::now()->addDays('7')->format("Y-m-d H:m:s");

        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        $barang = DB::table('barang_has_kadaluarsa')
                    ->select('barang_has_kadaluarsa.barang_id', 'barang.kode', 'barang.nama', 'barang.harga_jual', 'barang.diskon_potongan_harga')
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $now)
                    ->where('barang_has_kadaluarsa.jumlah_stok_di_rak', '>', 0)
                    ->join('barang', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->groupBy('barang_has_kadaluarsa.barang_id')
                    ->get();

        // mengambil tanggal kadaluarsa terlama 
        $barang_has_kadaluarsa = DB::table('barang')
                                    ->select('barang.*', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_rak as jumlah_stok')
                                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $now)
                                    ->where('barang_has_kadaluarsa.jumlah_stok_di_rak', '>', 0)
                                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                    ->get();

        $anggotaKopkar = DB::table('users')->where('status_verifikasi_anggota', '=', 'Verified')->get();

        return view ('admin.penjualan_offline.tambah', ['barang' => $barang, 'barang_has_kadaluarsa' => $barang_has_kadaluarsa, 'anggotaKopkar' => $anggotaKopkar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nomor_nota' => 'unique:penjualan'
        ];
  
        $messages = [
            'nomor_nota.unique'=> 'Sudah ada nomor nota yang sama'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $barang_konsinyasi = isset($request->barang_konsinyasi) ? $request->barang_konsinyasi : 0;
        $stok_minimum = isset($request->stok_minimum) ? $request->stok_minimum : 0;
        $pelanggan_kopkar = isset($request->pelanggan_kopkar) ? $request->pelanggan_kopkar : null;
        $total = 0;
        
        $id_pembayaran = DB::table('pembayaran')
                            ->insertGetId([
                                'metode_pembayaran' => $request->metodePembayaran,
                                'status_bayar' => 'Sudah lunas',
                                'batasan_waktu' => \Carbon\Carbon::now(),
                                'waktu_lunas' => \Carbon\Carbon::now()
                            ]);

        $id_penjualan = DB::table('penjualan')
                            ->insertGetId([
                                'nomor_nota' => $request->nomor_nota,
                                'tanggal' => $request->tanggal,
                                'pembayaran_id' => $id_pembayaran,
                                'users_id' => $pelanggan_kopkar,
                                'jenis' => 'Offline',
                                'metode_transaksi' => 'Ambil di toko',
                                'status_jual' => 'Pesanan sudah dibayar',
                                'created_at' => \Carbon\Carbon::now(),
                                'updated_at' => \Carbon\Carbon::now()
                            ]);

        $detail_penjualan = json_decode($request->detail_penjualan, true);
        
        for($i = 0; $i < count((array) $detail_penjualan); $i++)
        {
            //hitung total
            $total += $detail_penjualan[$i]['subtotal'];

            $cariBarang = DB::table('barang_has_kadaluarsa')
                            ->select('barang_id')
                            ->where('barang_id', '=', $detail_penjualan[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $detail_penjualan[$i]['tanggal_kadaluarsa'])
                            ->get();

            $kurangiStok = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $detail_penjualan[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $detail_penjualan[$i]['tanggal_kadaluarsa'])
                            ->decrement('jumlah_stok_di_rak', $detail_penjualan[$i]['kuantitas']);

            $insert_detail_penjualan = DB::table('detail_penjualan')
                                        ->insert([
                                            'penjualan_id' => $id_penjualan,
                                            'barang_id' => $cariBarang[0]->barang_id,
                                            'tanggal_kadaluarsa' => $detail_penjualan[$i]['tanggal_kadaluarsa'],
                                            'kuantitas' => $detail_penjualan[$i]['kuantitas'],
                                            'subtotal' => $detail_penjualan[$i]['subtotal']
                                        ]);
            
        }

        $update = DB::table('penjualan')->where('id','=',$id_penjualan)->update(['total' => $total]);

        return redirect()->route('penjualanoffline.index')->with(['success' => 'Data penjualan berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualanOffline = DB::table('penjualan')
                                ->select('penjualan.nomor_nota',
                                         'penjualan.tanggal',
                                         'penjualan.status_retur',
                                         'penjualan.total',
                                         'penjualan.users_id',
                                         'pembayaran.metode_pembayaran')
                                ->where('penjualan.id', '=', $id)
                                ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                                ->get();

        if($penjualanOffline[0]->users_id != null) 
        {
            $penjualanOffline = DB::table('penjualan')
                                ->select('penjualan.nomor_nota',
                                         'penjualan.tanggal',
                                         'users.nama_depan',
                                         'users.nama_belakang',
                                         'penjualan.status_retur',
                                         'penjualan.users_id',
                                         'penjualan.total',
                                         'pembayaran.metode_pembayaran')
                                ->where('penjualan.id', '=', $id)
                                ->join('users', 'penjualan.users_id', '=', 'users.id')
                                ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                                ->get();
        }                       
        
        $detailPenjualanOffline = DB::table('detail_penjualan')
                                    ->select('barang.kode',
                                             'barang.nama',
                                             'barang.harga_jual',
                                             'barang.diskon_potongan_harga', 
                                             'detail_penjualan.*')
                                    ->where('detail_penjualan.penjualan_id', '=', $id)
                                    ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                                    ->get();

        return view('admin.penjualan_offline.lihat', ['penjualan_offline' => $penjualanOffline, 'detail_penjualan_offline' => $detailPenjualanOffline]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->reset($id);

        $penjualanOffline = DB::table('penjualan')
                                ->select('penjualan.id',
                                         'penjualan.nomor_nota',
                                         'penjualan.tanggal',
                                         'penjualan.status_retur',
                                         'penjualan.total',
                                         'penjualan.users_id',
                                         'pembayaran.metode_pembayaran',
                                         'penjualan.pembayaran_id')
                                ->where('penjualan.id', '=', $id)
                                ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                                ->get();

        if($penjualanOffline[0]->users_id != null) 
        {
            $penjualanOffline = DB::table('penjualan')
                                ->select('penjualan.id',
                                         'penjualan.nomor_nota',
                                         'penjualan.tanggal',
                                         'users.nama_depan',
                                         'users.nama_belakang',
                                         'users.nomor_anggota',
                                         'penjualan.status_retur',
                                         'penjualan.users_id',
                                         'penjualan.total',
                                         'pembayaran.metode_pembayaran')
                                ->where('penjualan.id', '=', $id)
                                ->join('users', 'penjualan.users_id', '=', 'users.id')
                                ->join('pembayaran', 'penjualan.pembayaran_id', '=', 'pembayaran.id')
                                ->get();
        }     

        $detailPenjualanOffline = DB::table('detail_penjualan')
                                    ->select('barang.kode',
                                             'barang.nama',
                                             'barang.harga_jual',
                                             'barang.diskon_potongan_harga', 
                                             'detail_penjualan.*')
                                    ->where('detail_penjualan.penjualan_id', '=', $id)
                                    ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                                    ->get();

        $anggotaKopkar = DB::table('users')
                            ->where('jenis', 'Anggota_Kopkar')
                            ->get();

        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        $barang = DB::table('barang_has_kadaluarsa')
                    ->select('barang_has_kadaluarsa.barang_id', 'barang.kode', 'barang.nama', 'barang.harga_jual', 'barang.diskon_potongan_harga')
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $now)
                    ->where('barang_has_kadaluarsa.jumlah_stok_di_rak', '>', 0)
                    ->join('barang', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->groupBy('barang_has_kadaluarsa.barang_id')
                    ->get();

        // mengambil tanggal kadaluarsa terlama 
        $barang_has_kadaluarsa = DB::table('barang')
                                    ->select('barang.*', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_rak as jumlah_stok')
                                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $now)
                                    ->where('barang_has_kadaluarsa.jumlah_stok_di_rak', '>', 0)
                                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                    ->get();

        return view('admin.penjualan_offline.ubah', ['penjualan_offline' => $penjualanOffline, 'detail_penjualan_offline' => $detailPenjualanOffline, 'anggotaKopkar' => $anggotaKopkar, 'barang' => $barang, 'barang_has_kadaluarsa' => $barang_has_kadaluarsa]);
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
        $cek_kode = DB::table('penjualan')->select('nomor_nota')->whereNotIn('id', [$id])->get();

        $cari = false;

        for($i=0; $i<count($cek_kode); $i++)
        {
            if(strtolower($request->nomor_nota) == strtolower($cek_kode[$i]->nomor_nota))
            {
                $cari = true;
            }
        }
  
        if($cari){
            return redirect()->back()->withErrors(['msg' => 'Nomor nota yang sama sudah ada'])->withInput($request->all);
        }

        $updatePembayaran = DB::table('pembayaran')
                                ->where('id', $request->pembayaran_id)
                                ->update([
                                    'metode_pembayaran' => $request->metode_pembayaran
                                ]);

        $pelanggan_kopkar = isset($request->pelanggan_kopkar) ? $request->pelanggan_kopkar : null;

        $updatePenjualan = DB::table('penjualan')
                                ->where('id', $id)
                                ->update([
                                    'tanggal' => $request->tanggal,
                                    'users_id' => $pelanggan_kopkar,
                                    'updated_at'=> \Carbon\Carbon::now()
                                ]);

        $deleteDetailPenjualan = DB::table('detail_penjualan')
                                    ->where('penjualan_id', '=', $id)
                                    ->delete();

        $total = 0;

        $detail_penjualan = json_decode($request->detail_penjualan, true);
        
        dd($detail_penjualan);
        
        for($i = 0; $i < count((array) $detail_penjualan); $i++)
        {
            //hitung total
            $total += $detail_penjualan[$i]['subtotal'];

            $cariBarang = DB::table('barang_has_kadaluarsa')
                            ->select('barang_id')
                            ->where('barang_id', '=', $detail_penjualan[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $detail_penjualan[$i]['tanggal_kadaluarsa'])
                            ->get();

            $kurangiStok = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $detail_penjualan[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $detail_penjualan[$i]['tanggal_kadaluarsa'])
                            ->decrement('jumlah_stok_di_rak', $detail_penjualan[$i]['kuantitas']);

            $insert_detail_penjualan = DB::table('detail_penjualan')
                                        ->insert([
                                            'penjualan_id' => $id_penjualan,
                                            'barang_id' => $cariBarang[0]->barang_id,
                                            'tanggal_kadaluarsa' => $detail_penjualan[$i]['tanggal_kadaluarsa'],
                                            'kuantitas' => $detail_penjualan[$i]['kuantitas'],
                                            'subtotal' => $detail_penjualan[$i]['subtotal']
                                        ]);
            
        }

        $update = DB::table('penjualan')->where('id','=',$id_penjualan)->update(['total' => $total]);

        return redirect()->route('penjualanoffline.index')->with(['success' => 'Data penjualan berhasil diubah']);
    }

    public function reset($id)
    {
        $detail_penjualan = DB::table('detail_penjualan')
                                ->where('penjualan_id', '=', $id)
                                ->get();

        foreach($detail_penjualan as $item)
        {
            $barang_has_kadaluarsa = DB::table('barang_has_kadaluarsa')
                                        ->where('barang_id', '=', $item->barang_id)
                                        ->where('tanggal_kadaluarsa', '=', $item->tanggal_kadaluarsa)
                                        ->increment('jumlah_stok_di_rak', $item->kuantitas);
        }
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

        $deleteDetailPenjualan = DB::table('detail_penjualan')
                                    ->where('penjualan_id', '=', $id)
                                    ->delete();

        $delete = DB::table('penjualan')
                    ->where('id', '=', $id)
                    ->delete();

        return redirect()->route('penjualanoffline.index')->with(['success' => 'Data pernjualan berhasil dihapus']);
    }
}
