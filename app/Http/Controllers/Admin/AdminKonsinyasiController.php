<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class AdminKonsinyasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konsinyasi = DB::table('konsinyasi')
                        ->select('konsinyasi.*', 'supplier.nama as nama_supplier')
                        ->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')
                        ->get();
        
        $supplier = DB::table('supplier')
                    ->where('jenis', '=', 'Individu')
                    ->get();

        return view('admin.konsinyasi.index', ['konsinyasi' => $konsinyasi, 'supplier' => $supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = DB::table('supplier')->where('jenis', '=', 'Individu')->get();
        $barang_konsinyasi = DB::table('barang')->where('barang_konsinyasi', '=', 1)->get();

        $generateNomorNota = DB::table('konsinyasi')
                                ->select(DB::raw('max(nomor_nota) as maxNomorNota'))
                                ->get();

        return view('admin.konsinyasi.tambah', ['supplier' => $supplier, 'barang_konsinyasi' => $barang_konsinyasi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $barang = DB::table('barang')
                    ->where('supplier_id', '=', $request->supplier_id)
                    ->get();

        // $konsinyasiYgMirip = DB::table('konsinyasi')
        //                 ->where('supplier_id', '=', $request->supplier_id)
        //                 ->where('tanggal_titip', '<=', $request->tanggal_titip)
        //                 ->where('tanggal_jatuh_tempo', '>=', $request->tanggal_jatuh_tempo)
        //                 ->get();

        $konsinyasiYgMirip = DB::table('konsinyasi')
                                ->where('supplier_id', '=', $request->supplier_id)
                                ->whereBetween('tanggal_titip', [date($request->tanggal_titip), date($request->tanggal_jatuh_tempo)])
                                ->get();


        if(count($barang) == 0)
        {
            return redirect()->back()->with(['error' => 'Gagal simpan konsinyasi. Tidak ada riwayat barang dari penitip']);
        }
        else if(count($konsinyasiYgMirip) > 0)
        {
            return redirect()->back()->with(['error' => 'Gagal simpan konsinyasi. Sudah ada data konsinyasi dengan penitip yang sama']);
        }

        $konsinyasi = DB::table('konsinyasi')
                        ->insertGetId([
                            'nomor_nota' => $request->nomor_nota,
                            'tanggal_titip' => \Carbon\Carbon::parse($request->tanggal_titip)->format('Y-m-d'),
                            'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggal_jatuh_tempo)->format('Y-m-d'),
                            'supplier_id' => $request->supplier_id,
                            'metode_pembayaran' => $request->metode_pembayaran
                        ]);

        return redirect()->route('konsinyasi.add.barang', ['konsinyasi' => $konsinyasi]);
    
    }

    public function addBarangKonsinyasi(Request $request, $id)
    {
        $konsinyasi = DB::table('konsinyasi')
                         ->select('konsinyasi.*', 'supplier.nama as nama_supplier')
                         ->where('konsinyasi.id', $id)
                         ->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')
                         ->get();

        $barang_konsinyasi = DB::table('barang')
                                ->where('barang_konsinyasi', '=', 1)
                                ->where('supplier_id', '=', $konsinyasi[0]->supplier_id)
                                ->get();

        return view('admin.konsinyasi.tambah', ['barang_konsinyasi' => $barang_konsinyasi, 'konsinyasi' => $konsinyasi]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {                
        $konsinyasi = DB::table('konsinyasi')
                        ->select(DB::raw("CONCAT(barang.kode, ' - ', barang.nama) AS barang_nama"), 'konsinyasi.*', 'detail_konsinyasi.*', 'supplier.nama as nama_supplier', 'barang.harga_jual', 'barang.diskon_potongan_harga', 'barang_has_kadaluarsa.jumlah_stok', 'barang_has_kadaluarsa.tanggal_kadaluarsa')
                        ->join('detail_konsinyasi', 'konsinyasi.id', '=', 'detail_konsinyasi.konsinyasi_id')
                        ->join('supplier', 'konsinyasi.supplier_id', '=', 'supplier.id')
                        ->join('barang', 'barang.id', '=', 'detail_konsinyasi.barang_id')
                        ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.tanggal_kadaluarsa', '=', 'detail_konsinyasi.tanggal_kadaluarsa')
                        ->where('konsinyasi.id', '=', $id)
                        ->groupBy('barang.id')
                        ->get();

        $detailKonsinyasi = array();

        $total_komisi = 0;
        
        $total_hutang = 0;

        $total_sisa = 0;

        for($i = 0; $i < count($konsinyasi); $i++)
        {
            $penjualan = DB::table('detail_penjualan')
                            ->select('penjualan.tanggal', 'detail_penjualan.barang_id', DB::raw('sum(detail_penjualan.kuantitas) as kuantitas'))
                            ->where('barang_has_kadaluarsa.barang_id', '=', $konsinyasi[$i]->barang_id)
                            ->where('barang_has_kadaluarsa.tanggal_kadaluarsa', '=', $konsinyasi[$i]->tanggal_kadaluarsa)
                            ->where('penjualan.status_jual', '=', 'Pesanan sudah selesai')
                            ->whereBetween('penjualan.tanggal', [$konsinyasi[$i]->tanggal_titip, $konsinyasi[$i]->tanggal_jatuh_tempo])
                            ->join('penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
                            ->join('barang_has_kadaluarsa', 'barang_has_kadaluarsa.barang_id', '=', 'detail_penjualan.barang_id')
                            ->join('barang', 'barang.id', '=', 'detail_penjualan.barang_id')
                            ->get();
            
            $barangRetur = DB::table('retur_pembelian')
                            ->select('barang_retur', DB::raw("sum(kuantitas_barang_retur) as jumlah_retur"))
                            // ->where('kebijakan_retur', '=', 'Retur Sisa Barang Konsinyasi')
                            // ->where('kebijakan_retur', '=', 'Potong Dana Pembelian')
                            ->whereBetween('tanggal', [$konsinyasi[$i]->tanggal_titip, $konsinyasi[$i]->tanggal_jatuh_tempo])
                            ->join('detail_retur_pembelian', 'retur_pembelian.id', '=', 'detail_retur_pembelian.retur_pembelian_id')
                            ->where('retur_pembelian.konsinyasi_id', '=', $id)
                            ->groupBy('barang_retur')
                            ->get();
            
            $object = new \stdClass();

            if(count($penjualan) > 0 && $penjualan[0]->tanggal == null)
            {  
                $object->barang_id = $konsinyasi[$i]->barang_id;
                $object->barang_tanggal_kadaluarsa = $konsinyasi[$i]->tanggal_kadaluarsa;
                $object->barang_nama = $konsinyasi[$i]->barang_nama;
                $object->barang_harga_jual = $konsinyasi[$i]->harga_jual;
                $object->barang_diskon = $konsinyasi[$i]->diskon_potongan_harga;
                $object->jumlah_titip = $konsinyasi[$i]->jumlah_titip;
                $object->terjual = 0;
                $object->retur = 0;

                if(count($barangRetur) > 0)
                {
                    foreach($barangRetur as $item)
                    {
                        if($konsinyasi[$i]->barang_id == $item->barang_retur)
                        {
                            $object->retur = $item->jumlah_retur;
                        }
                    }
                }
                else 
                {
                    $object->retur = 0;
                }

                $object->sisa = $object->jumlah_titip-$object->terjual-$object->retur;
                $object->komisi = $konsinyasi[$i]->komisi;
                $object->hutang = $konsinyasi[$i]->hutang;
                $object->jumlah_stok = $konsinyasi[$i]->jumlah_stok;
                $object->subtotal_komisi = 0;
                $object->subtotal_hutang = 0;
            }
            else 
            {
                for($x = 0; $x < count($penjualan); $x++)
                {
                    $object->barang_id = $konsinyasi[$i]->barang_id;
                    $object->barang_tanggal_kadaluarsa = $konsinyasi[$i]->tanggal_kadaluarsa;
                    $object->barang_nama = $konsinyasi[$i]->barang_nama;
                    $object->barang_harga_jual = $konsinyasi[$i]->harga_jual;
                    $object->barang_diskon = $konsinyasi[$i]->diskon_potongan_harga;
                    $object->jumlah_titip = $konsinyasi[$i]->jumlah_titip;
                    $object->terjual = $penjualan[$x]->kuantitas;
                    $object->komisi = $konsinyasi[$i]->komisi;
                    $object->hutang = $konsinyasi[$i]->hutang;

                    if(count($barangRetur) > 0)
                    {
                        foreach($barangRetur as $item)
                        {
                            if($konsinyasi[$i]->barang_id == $item->barang_retur)
                            {
                                $object->retur = $item->jumlah_retur;
                            }
                        }
                    }
                    else 
                    {
                        $object->retur = 0;
                    }

                    $object->sisa = $object->jumlah_titip-$object->terjual-$object->retur;
                    // $object->jumlah_stok = $konsinyasi[$i]->jumlah_stok;
                    $object->subtotal_komisi = $object->komisi*$object->sisa;
                    $object->subtotal_hutang = $object->hutang*$object->terjual;
                    
                }
            }

            $total_komisi += $object->subtotal_komisi;

            $total_hutang += $object->subtotal_hutang;

            $total_sisa += $object->sisa;

            array_push($detailKonsinyasi, $object);
 
        }

        $showNomorNotaRetur = false;

        if($total_sisa > 0)
        {
            $showNomorNotaRetur = true;
        }

        if($request->ajax())
        {
            return response()->json(['total_komisi' => $total_komisi, 'total_hutang' => $total_hutang, 'nomor_nota' => $konsinyasi[0]->nomor_nota, 'show_nomor_nota_retur' => $showNomorNotaRetur, 'detail_konsinyasi' => $detailKonsinyasi]);
        }
        else
        {
            return view('admin.konsinyasi.detail', ['konsinyasi' => $konsinyasi, 'detail_konsinyasi' => $detailKonsinyasi, 'total_komisi' => $total_komisi, 'total_hutang' => $total_hutang]);
        }



    }

    public function loadKonsinyasi($konsinyasi, $barangKonsinyasi)
    {
        $tanggalTitip = $konsinyasi[0]->tanggal_titip;
        $tanggalJatuhTempo = $konsinyasi[0]->tanggal_jatuh_tempo;

        $terjual = 0;
        $hutang = 0;
        $komisi = 0;

        for($i = 0; $i < count($barangKonsinyasi); $i++)
        {
            $penjualan = DB::table('detail_penjualan')
                        ->select('detail_penjualan.*', 'barang.*')
                        ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                        ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
                        ->where('detail_penjualan.barang_id', '=', $barangKonsinyasi[$i]->barang_id)
                        ->where('penjualan.status', '=', 'Pesanan sudah dibayar')
                        ->whereBetween('tanggal', [$konsinyasi[0]->tanggal_titip, $konsinyasi[0]->tanggal_jatuh_tempo])
                        ->get();

        }
    }

    public function lunasi(Request $request, $id)
    {
        $arrDetailKonsinyasi = json_decode($request->detail_konsinyasi, true);

        if(isset($request->nomor_nota_retur))
        {
            $idReturPembelian = DB::table('retur_pembelian')
                                ->insertGetId([
                                    'tanggal' => \Carbon\Carbon::now()->format('Y-m-d'),
                                    'nomor_nota' => $request->nomor_nota_retur,
                                    'users_id' => auth()->user()->id,
                                    'konsinyasi_id' => $id,
                                    'kebijakan_retur' => 'Retur barang konsinyasi',
                                    'total' => $request->total_hutang
                                ]);

            for($i = 0; $i < count($arrDetailKonsinyasi); $i++)
            {
                if( $arrDetailKonsinyasi[$i]['sisa'] > 0)
                {
                    $barangKonsinyasi = DB::table('barang_has_kadaluarsa')
                                            ->where('barang_id', '=', $arrDetailKonsinyasi[$i]['barang_id'])
                                            ->where('tanggal_kadaluarsa', '=', $arrDetailKonsinyasi[$i]['barang_tanggal_kadaluarsa'])
                                            ->get();
                    $kurangiStokBarangKonsinyasi = DB::table('barang_has_kadaluarsa')
                                                        ->where('barang_id', '=', $arrDetailKonsinyasi[$i]['barang_id'])
                                                        ->where('tanggal_kadaluarsa', '=', $arrDetailKonsinyasi[$i]['barang_tanggal_kadaluarsa'])
                                                        ->decrement('jumlah_stok', $arrDetailKonsinyasi[$i]['sisa']);
                            
                    $insertDetailReturPembelian = DB::table('detail_retur_pembelian')
                                                    ->insert([
                                                        'retur_pembelian_id' => $idReturPembelian,
                                                        'barang_retur' => $arrDetailKonsinyasi[$i]['barang_id'],
                                                        'tanggal_kadaluarsa_barang_retur' => $arrDetailKonsinyasi[$i]['barang_tanggal_kadaluarsa'],
                                                        'kuantitas_barang_retur' => $arrDetailKonsinyasi[$i]['sisa'],
                                                        'subtotal' => $arrDetailKonsinyasi[$i]['subtotal_hutang'],
                                                        'keterangan' => 'Sisa jumlah barang konsinyasi'
                                                    ]);
                }
            }
        }

        $updateKonsinyasi = DB::table('konsinyasi')
                                ->where('id', '=', $id)
                                ->update([
                                    'status_bayar' => 'Sudah lunas',
                                    'tanggal_pelunasan' => \Carbon\Carbon::parse($request->tanggal_pelunasan)->format('Y-m-d')
                                ]);
        
        return redirect()->route('konsinyasi.index')->with(['success' => 'Konsinyasi berhasil dilunasi']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $konsinyasi = DB::table('konsinyasi')
                        ->select('konsinyasi.*', 'supplier.nama as nama_supplier')
                        ->where('konsinyasi.id', '=', $id)
                        ->join('supplier', 'supplier.id', '=', 'konsinyasi.supplier_id')
                        ->get();

        $detailKonsinyasi = DB::table('detail_konsinyasi')
                                ->select('detail_konsinyasi.*', 'barang.kode', 'barang.nama', 'barang.harga_jual', 'barang.diskon_potongan_harga')
                                ->where('konsinyasi_id', '=', $id)
                                ->join('barang_has_kadaluarsa', 'detail_konsinyasi.barang_id', '=', 'barang_has_kadaluarsa.barang_id')
                                ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                ->groupBy('detail_konsinyasi.barang_id', 'detail_konsinyasi.tanggal_kadaluarsa')
                                ->get();

        $supplier = DB::table('supplier')->where('jenis', '=', 'Individu')->get();

        $barang_konsinyasi = DB::table('barang')->where('barang_konsinyasi', '=', 1)->where('supplier_id', '=', $konsinyasi[0]->supplier_id)->get();

        return view('admin.konsinyasi.ubah', ['konsinyasi' => $konsinyasi, 'detail_konsinyasi' => $detailKonsinyasi, 'supplier' => $supplier, 'barang_konsinyasi' => $barang_konsinyasi]);
    }

    public function reset($id)
    {
        $detailKonsinyasi = DB::table('detail_konsinyasi')
                                ->where('konsinyasi_id', '=', $id)
                                ->get();

        for($i = 0; $i < count(array($detailKonsinyasi)); $i++)
        {
            $stok= DB::table('barang_has_kadaluarsa')
                        ->select('jumlah_stok')
                        ->where('barang_id', '=', $detailKonsinyasi[$i]->barang_id)
                        ->where('tanggal_kadaluarsa', '=', $detailKonsinyasi[$i]->tanggal_kadaluarsa)
                        ->get();

            $qty = $stok[0]->jumlah_stok;

            if($detailKonsinyasi[$i]->jumlah_titip > $qty)
            {
                $kurangiStok = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailKonsinyasi[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailKonsinyasi[$i]->tanggal_kadaluarsa)
                                ->update([
                                    'jumlah_stok' => 0
                                ]);
            }
            else 
            {
                $kurangiStok = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $detailKonsinyasi[$i]->barang_id)
                                ->where('tanggal_kadaluarsa', '=', $detailKonsinyasi[$i]->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok', $detailKonsinyasi[$i]->jumlah_titip);

            }
        }

        $deleteDetailKonsinyasi = DB::table('detail_konsinyasi')
                                        ->where('konsinyasi_id', '=', $id)
                                        ->delete();
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
        $konsinyasiYgMirip = DB::table('konsinyasi')
                        ->where('supplier_id', '=', $request->supplier_id)
                        ->where('tanggal_titip', '<=', $request->tanggal_titip)
                        ->where('tanggal_jatuh_tempo', '>=', $request->tanggal_jatuh_tempo)
                        ->whereNotIn('id', [$id])
                        ->get();

        if(count($konsinyasiYgMirip) > 0)
        {
            return redirect()->back()->with(['error' => 'Gagal simpan konsinyasi. Sudah ada data konsinyasi dengan penitip yang sama']);
        }

        $this->reset($id);

        $update = DB::table('konsinyasi')
                    ->where('id', $id)
                    ->update([
                        'nomor_nota' => $request->nomor_nota,
                        'supplier_id' => $request->supplier_id,
                        'tanggal_titip' => \Carbon\Carbon::parse($request->tanggal_titip)->format('Y-m-d'),
                        'tanggal_jatuh_tempo' => \Carbon\Carbon::parse($request->tanggal_jatuh_tempo)->format('Y-m-d'),
                        'metode_pembayaran' => $request->metode_pembayaran
                    ]);

        $dataBarang = json_decode($request->barangKonsinyasi, true);

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
                                        'jumlah_stok' => $dataBarang[$i]['jumlah_titip']
                                    ]);
                    
            }
            else // jika ada barang yang sama maka tambah kuantitas
            {
                $addStokBarang = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                    ->increment('jumlah_stok', $dataBarang[$i]['jumlah_titip']);  

            }

            $insertDetailKonsinyasi = DB::table('detail_konsinyasi')
                                            ->insert([
                                                'konsinyasi_id'          => $id,
                                                'barang_id'             => $dataBarang[$i]['barang_id'],
                                                'tanggal_kadaluarsa'    => $tglKadaluarsa,
                                                'jumlah_titip'          => $dataBarang[$i]['jumlah_titip'],
                                                'komisi'                => $dataBarang[$i]['komisi'],
                                                'hutang'                => $dataBarang[$i]['hutang'],
                                                'subtotal_komisi'       => $dataBarang[$i]['komisi']*$dataBarang[$i]['jumlah_titip'],
                                                'subtotal_hutang'       => $dataBarang[$i]['hutang']*$dataBarang[$i]['jumlah_titip']
                                            ]);

        }

        return redirect()->route('konsinyasi.index')->with(['success', 'Data konsinyasi berhasil diubah']);
    }

    public function storeBarangKonsinyasi(Request $request)
    {
        $barangKonsinyasi = json_decode($request->barangKonsinyasi, true);

        for($i = 0; $i < count((array) $barangKonsinyasi); $i++)
        {      
            $tglKadaluarsa = $barangKonsinyasi[$i]['tanggal_kadaluarsa'] != "Tidak ada" ? $barangKonsinyasi[$i]['tanggal_kadaluarsa'] : '9999-12-12 00:00:00';

            $selectBarang = DB::table('barang_has_kadaluarsa')
                            ->where('barang_id', '=', $barangKonsinyasi[$i]['barang_id'])
                            ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                            ->get();

            if (count($selectBarang) == 0) // jika tidak ada barang yang sama maka tambah baru
            {

                $tambahBarangKonsinyasi = DB::table('barang_has_kadaluarsa')
                                            ->insert([
                                                'barang_id' => $barangKonsinyasi[$i]['barang_id'],
                                                'tanggal_kadaluarsa' => $tglKadaluarsa,
                                                'jumlah_stok' => $barangKonsinyasi[$i]['jumlah_titip']
                                            ]);
                 
            }
            else // jika ada barang yang sama maka tambah kuantitas
            {
                $tambahStokBarangKonsinyasi = DB::table('barang_has_kadaluarsa')
                                                ->where('barang_id', '=', $barangKonsinyasi[$i]['barang_id'])
                                                ->where('tanggal_kadaluarsa', '=', $tglKadaluarsa)
                                                ->increment('jumlah_stok', $barangKonsinyasi[$i]['jumlah_titip']);  

            }

            $insertDetailKonsinyasi = DB::table('detail_konsinyasi')
                                        ->insert([
                                            'konsinyasi_id' => $request->konsinyasi_id,
                                            'barang_id' => $barangKonsinyasi[$i]['barang_id'],
                                            'jumlah_titip' => $barangKonsinyasi[$i]['jumlah_titip'],
                                            'tanggal_kadaluarsa' => $tglKadaluarsa,
                                            'komisi' => $barangKonsinyasi[$i]['komisi'],
                                            'subtotal_komisi' => $barangKonsinyasi[$i]['komisi']*$barangKonsinyasi[$i]['jumlah_titip'],
                                            'hutang' => $barangKonsinyasi[$i]['hutang'],
                                            'subtotal_hutang' => $barangKonsinyasi[$i]['hutang']*$barangKonsinyasi[$i]['jumlah_titip']
                                        ]);

            
         }

        return redirect()->route('konsinyasi.index')->with(['success' => 'Data konsinyasi berhasil ditambah']);

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

        $delete = DB::table('konsinyasi')->where('id', $id)->delete();

        return redirect()->back()->with(['success' => 'Data konsinyasi berhasil dihapus']);
    }
}
