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

        // mengambil tanggal kadaluarsa terlama 
        $barang = DB::table('barang')
                    ->select('barang.*', DB::raw('max(barang_has_kadaluarsa.tanggal_kadaluarsa) as tanggal_kadaluarsa'), DB::raw('sum(barang_has_kadaluarsa.jumlah_stok) as jumlah_stok'))
                    ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '>', $now)
                    ->where('barang_has_kadaluarsa.jumlah_stok', '>', 0)
                    ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                    ->groupBy('barang_has_kadaluarsa.barang_id')
                    ->get();

        $anggotaKopkar = DB::table('users')->where('status_verifikasi_anggota', '=', 'Verified')->get();

        $generateNomorNota = DB::table('penjualan')
                                ->select(DB::raw('max(nomor_nota) as maxNomorNota'))
                                ->where('jenis', '=', 'Offline')
                                ->get();

        // $generateNomorNota = isset($generateNomorNota[0]->maxNomorNota) ? $generateNomorNota[0]->maxNomorNota + 1 : 01;

        // $generateNomorNota = 'NJ'.\Carbon\Carbon::now()->format('dmy').sprintf("%03s", $generateNomorNota);

        return view ('admin.penjualan_offline.tambah', ['barang' => $barang, 'anggotaKopkar' => $anggotaKopkar]);
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
                                'batasan_waktu' => \Carbon\Carbon::now()
                            ]);

        $id_penjualan = DB::table('penjualan')
                            ->insertGetId([
                                'nomor_nota' => $request->nomor_nota,
                                'tanggal' => $request->tanggal,
                                'pembayaran_id' => $id_pembayaran,
                                'users_id' => $pelanggan_kopkar,
                                'jenis' => 'Offline',
                                'metode_transaksi' => 'Ambil di toko',
                                'status' => 'Pesanan sudah dibayar'
                            ]);

        $detail_penjualan = json_decode($request->detail_penjualan, true);
        
        for($i = 0; $i < count((array) $detail_penjualan); $i++)
        {
            //hitung total
            $total += $detail_penjualan[$i]['subtotal'];
        
            $qty= $detail_penjualan[$i]["kuantitas"]*1;

            // kurangi stok
            $dtBarang = DB::table('barang_has_kadaluarsa')
                                 ->where('barang_id', '=', $detail_penjualan[$i]['barang_id'])
                                 ->where('jumlah_stok','>',0)
                                 ->whereRaw('tanggal_kadaluarsa >= SYSDATE()')
                                 ->orderBy('tanggal_kadaluarsa','ASC')
                                 ->get();

            for ($j=0;$j<count($dtBarang);$j++)
            {
                $stok=$dtBarang[$j]->jumlah_stok*1;

                if ($qty>0)
                {
                    if ($qty>$stok)
                    {
                        $kurangiStok = DB::table('barang_has_kadaluarsa')->where('id','=',$dtBarang[$j]->id)->update(['jumlah_stok' => 0]);
                        $qty-=$stok;
                    }
                    else {
                        $stokBaru=$stok-$qty;
                        $kurangiStok = DB::table('barang_has_kadaluarsa')->where('id','=',$dtBarang[$j]->id)->update(['jumlah_stok' => $stokBaru]);
                        $qty=0;

                    }
                }
            }

            $insert_detail_penjualan = DB::table('detail_penjualan')
                                        ->insert([
                                            'penjualan_id' => $id_penjualan,
                                            'barang_id' => $detail_penjualan[$i]['barang_id'],
                                            'kuantitas' => $detail_penjualan[$i]['kuantitas'],
                                            'subtotal' => $detail_penjualan[$i]['subtotal']
                                        ]);
            
        }

        $update = DB::table('penjualan')->where('id','=',$id_penjualan)->update(['total' => $total]);

        return redirect()->route('penjualanoffline.index')->with(['success' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
