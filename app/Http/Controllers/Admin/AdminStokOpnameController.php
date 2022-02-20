<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminStokOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomorStokOpname = DB::table('stok_opname')
                            ->select(DB::raw('max(id) as nomor_stok_opname'))
                            ->get();

        $nomor_stok_opname = $nomorStokOpname[0]->nomor_stok_opname;

        if($nomor_stok_opname == null)
        {
            $nomor_stok_opname = 1;
        }
        else 
        {
            $nomor_stok_opname += 1;
        }

        $stok_opname = DB::table('stok_opname')
                        ->select('stok_opname.id as nomor', 'stok_opname.tanggal', 'users.nama_depan', 'users.nama_belakang', 'stok_opname.lokasi_stok')
                        ->join('users', 'stok_opname.users_id', '=', 'users.id')
                        ->get();

        return view('admin.stok_opname.index', ['stok_opname' => $stok_opname, 'nomor_stok_opname' => $nomor_stok_opname]);
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
                    ->where('barang_konsinyasi', '=', 0)->get();

        $barangTglKadaluarsa = DB::table('barang_has_kadaluarsa')
                    ->select('barang.*', 'barang_has_kadaluarsa.tanggal_kadaluarsa as tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as jumlah_stok')
                    ->join('barang', 'barang.id', '=', 'barang_has_kadaluarsa.barang_id')
                    ->whereRaw('barang_has_kadaluarsa.tanggal_kadaluarsa > SYSDATE()')
                    ->where('barang.barang_konsinyasi', '=', 0)->get();

        // dd($barang);
        // dd($barangTglKadaluarsa);

        return view('admin.stok_opname.tambah', ['barang'=>$barang, 'barangTglKadaluarsa'=>$barangTglKadaluarsa]);
    }

    public function storeStokOpname($id)
    {
        if(session()->get('redirect') || str_contains(url()->previous(), '/stok_opname/add/'.$id))
        {
            $stokOpname = DB::table('stok_opname')
            ->select('stok_opname.*', 'users.nama_depan', 'users.nama_belakang')
            ->where('stok_opname.id', $id)
            ->join('users', 'stok_opname.users_id', '=', 'users.id')
            ->get();

            if($stokOpname[0]->lokasi_stok == "Gudang")
            {
                $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                    ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as jumlah_stok')
                                    ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                    ->get();
            }
            else 
            {
                $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                        ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_rak as jumlah_stok')
                                        ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                        ->get();
            }

            $barang = DB::table('barang')
                ->select('barang.id', 'barang.kode', 'barang.nama')
                ->get();

            return view('admin.stok_opname.tambah', ['stok_opname' => $stokOpname, 'barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang])->with(['success' => 'Data transfer barang berhasil ditambah. Silahkan lengkapi barang yang ditransfer']);
        }
        else
        {
            abort(404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $IDstokOpname = DB::table('stok_opname')
                         ->insertGetId([
                             'tanggal' => $request->tanggal,
                             'users_id' => auth()->user()->id,
                             'lokasi_stok' => $request->lokasi_stok
                         ]);

        return redirect()->route('stok_opname.storeStokOpname', ['stok_opname' => $IDstokOpname])->with(['redirect' => 1]);

    }

    public function storeDetailStokOpname(Request $request)
    {
        $dataBarang = json_decode($request->barang, true);

        for($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $insertDetailStokOpname = DB::table('detail_stok_opname')
                                        ->insert([
                                            'stok_opname_id' => $request->stok_opname_id,
                                            'barang_id' => $dataBarang[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $dataBarang[$i]['barang_tanggal_kadaluarsa'],
                                            'stok_di_sistem' => $dataBarang[$i]['stok_di_sistem'],
                                            'stok_di_toko' => $dataBarang[$i]['stok_di_toko'],
                                            'jumlah_selisih' => $dataBarang[$i]['selisih'],
                                            'keterangan' => $dataBarang[$i]['keterangan']
                                        ]);

            if($request->lokasi_stok == "Rak")
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_rak', $dataBarang[$i]['selisih']);
            }
            else 
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_gudang', $dataBarang[$i]['selisih']);
            }
        }

        return redirect()->route('stok_opname.index')->with(['success' => 'Data berhasil ditambah']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $history_edit = DB::table('history_edit')
                            ->select('history_edit.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('edit_id', '=', $id)
                            ->where('keterangan', '=', 'stok_opname')
                            ->join('users', 'users.id', '=', 'history_edit.users_id')
                            ->get();

        $stok_opname = DB::table('stok_opname')
                        ->select('stok_opname.id as nomor', 'stok_opname.tanggal', 'users.nama_depan', 'users.nama_belakang', 'stok_opname.lokasi_stok')
                        ->join('users', 'stok_opname.users_id', '=', 'users.id')
                        ->where('stok_opname.id', '=', $id)
                        ->get();

        $detail_stok_opname = DB::table('detail_stok_opname')
                                ->select('detail_stok_opname.barang_id', 
                                         'detail_stok_opname.tanggal_kadaluarsa', 
                                         'detail_stok_opname.stok_di_sistem',
                                         'detail_stok_opname.stok_di_toko',
                                         'detail_stok_opname.jumlah_selisih',
                                         'detail_stok_opname.keterangan',
                                         'barang.kode',
                                         'barang.nama')
                                ->join('barang', 'detail_stok_opname.barang_id', 'barang.id')
                                ->where('detail_stok_opname.stok_opname_id', '=', $id)
                                ->get();

        return view('admin.stok_opname.lihat', ['stok_opname' => $stok_opname, 'detail_stok_opname' => $detail_stok_opname, 'history_edit' => $history_edit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if($request->ajax())
        {
            $stok_opname = DB::table('stok_opname')
                        ->select('stok_opname.id as nomor', 'stok_opname.tanggal', 'users.nama_depan', 'users.nama_belakang', 'stok_opname.lokasi_stok')
                        ->join('users', 'stok_opname.users_id', '=', 'users.id')
                        ->where('stok_opname.id', '=', $id)
                        ->get();

            return response()->json(['stok_opname' => $stok_opname]);
        }
        
    }

    public function reset($id, $lokasiStok)
    {
        $detailStokOpname = DB::table('detail_stok_opname')
                                ->where('stok_opname_id', '=', $id)
                                ->get();
        
        if($lokasiStok == "Rak")
        {
            foreach($detailStokOpname as $item)
            {
                if($item->jumlah_selisih > 0)
                {
                    $update = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $item->barang_id)
                                ->where('tanggal_kadaluarsa', $item->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok_di_rak', $item->jumlah_selisih);
                }
                elseif($item->jumlah_selisih < 0) 
                {
                    $update = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $item->barang_id)
                                ->where('tanggal_kadaluarsa', $item->tanggal_kadaluarsa)
                                ->increment('jumlah_stok_di_rak', $item->jumlah_selisih*-1);
                }
            }
        }
        else 
        {
            foreach($detailStokOpname as $item)
            {
                if($item->jumlah_selisih > 0)
                {
                    $update = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $item->barang_id)
                                ->where('tanggal_kadaluarsa', $item->tanggal_kadaluarsa)
                                ->decrement('jumlah_stok_di_gudang', $item->jumlah_selisih);
                }
                elseif($item->jumlah_selisih < 0) 
                {
                    $update = DB::table('barang_has_kadaluarsa')
                                ->where('barang_id', '=', $item->barang_id)
                                ->where('tanggal_kadaluarsa', $item->tanggal_kadaluarsa)
                                ->increment('jumlah_stok_di_gudang', $item->jumlah_selisih*-1);
                }
            }
        }

        $delete = DB::table('detail_stok_opname')
                    ->where('stok_opname_id', $id)
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
        $keterangan = "Lokasi stok sama";

        $stokOpname = DB::table('stok_opname')
                        ->where('id', '=', $id)
                        ->get();

        if($stokOpname[0]->lokasi_stok != $request->lokasi_stok)
        {
            $keterangan = "Lokasi stok tidak sama";
        }

        $update = DB::table('stok_opname')
                    ->where('id', '=', $id)
                    ->update([
                        'tanggal' => $request->tanggal,
                        'lokasi_stok' => $request->lokasi_stok
                    ]);
            
        return redirect()->route('stok_opname.editStokOpname', ['stok_opname' => $id, 'keterangan' => $keterangan]);
    }

    public function updateDetailStokOpname(Request $request, $id)
    {
        $this->reset($id, $request->lokasi_stok);

        $dataBarang = json_decode($request->barang, true);

        for($i = 0; $i < count((array) $dataBarang); $i++)
        {
            $insertDetailStokOpname = DB::table('detail_stok_opname')
                                        ->insert([
                                            'stok_opname_id' => $request->stok_opname_id,
                                            'barang_id' => $dataBarang[$i]['barang_id'],
                                            'tanggal_kadaluarsa' => $dataBarang[$i]['barang_tanggal_kadaluarsa'],
                                            'stok_di_sistem' => $dataBarang[$i]['stok_di_sistem'],
                                            'stok_di_toko' => $dataBarang[$i]['stok_di_toko'],
                                            'jumlah_selisih' => $dataBarang[$i]['selisih'],
                                            'keterangan' => $dataBarang[$i]['keterangan']
                                        ]);

            if($request->lokasi_stok == "Rak")
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_rak', $dataBarang[$i]['selisih']);
            }
            else 
            {
                $penyesuaianStok = DB::table('barang_has_kadaluarsa')
                                    ->where('barang_id', '=', $dataBarang[$i]['barang_id'])
                                    ->where('tanggal_kadaluarsa', '=', $dataBarang[$i]['barang_tanggal_kadaluarsa'])
                                    ->increment('jumlah_stok_di_gudang', $dataBarang[$i]['selisih']);
            }
        }

        $history_edit = DB::table('history_edit')
                            ->insert([
                                'users_id' => auth()->user()->id,
                                'tanggal' => \Carbon\Carbon::now(),
                                'edit_id' => $id,
                                'keterangan' => 'stok_opname'
                            ]);

        return redirect()->route('stok_opname.index')->with(['success' => 'Data stok opname berhasil diubah']);
    }

    public function editStokOpname(Request $request, $id)
    {
        // $this->reset($id, $request->lokasi_stok);

        $stokOpname = DB::table('stok_opname')
                            ->select('stok_opname.*', 'users.nama_depan', 'users.nama_belakang')
                            ->where('stok_opname.id', $id)
                            ->join('users', 'stok_opname.users_id', '=', 'users.id')
                            ->get();

        if($stokOpname[0]->lokasi_stok == "Gudang")
        {
            $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                    ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_gudang as jumlah_stok')
                                    ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                    ->get();
        }
        else 
        {
            $barangHasKadaluarsa = DB::table('barang_has_kadaluarsa')
                                        ->select('barang.id', 'barang.kode', 'barang.nama', 'barang_has_kadaluarsa.tanggal_kadaluarsa', 'barang_has_kadaluarsa.jumlah_stok_di_rak as jumlah_stok')
                                        ->join('barang', 'barang_has_kadaluarsa.barang_id', '=', 'barang.id')
                                        ->get();
        }

        $barang = DB::table('barang')
                    ->select('barang.id', 'barang.kode', 'barang.nama')
                    ->get();

        if($request->keterangan == "Lokasi stok sama")
        {
            if($stokOpname[0]->lokasi_stok == "Gudang")
            {
                $detail_stok_opname = DB::table('detail_stok_opname')
                                        ->select('detail_stok_opname.barang_id', 
                                                'detail_stok_opname.tanggal_kadaluarsa', 
                                                'detail_stok_opname.stok_di_sistem',
                                                'detail_stok_opname.stok_di_toko',
                                                'detail_stok_opname.jumlah_selisih',
                                                'detail_stok_opname.keterangan',
                                                'barang.kode',
                                                'barang.nama')
                                        ->join('barang', 'detail_stok_opname.barang_id', 'barang.id')
                                        ->where('detail_stok_opname.stok_opname_id', '=', $id)
                                        ->get();
            }
            else 
            {
                $detail_stok_opname = DB::table('detail_stok_opname')
                                        ->select('detail_stok_opname.barang_id', 
                                                'detail_stok_opname.tanggal_kadaluarsa', 
                                                'detail_stok_opname.stok_di_sistem',
                                                'detail_stok_opname.stok_di_toko',
                                                'detail_stok_opname.jumlah_selisih',
                                                'detail_stok_opname.keterangan',
                                                'barang.kode',
                                                'barang.nama')
                                        ->join('barang', 'detail_stok_opname.barang_id', 'barang.id')
                                        ->where('detail_stok_opname.stok_opname_id', '=', $id)
                                        ->get();

            }

            return view('admin.stok_opname.ubah', ['stok_opname' => $stokOpname, 'barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang, 'detail_stok_opname' => $detail_stok_opname])->with(['success' => 'Data transfer barang berhasil diubah. Silahkan lengkapi barang yang ingin dilakukan proses stok opname']);
        }
        else if($request->keterangan == "Lokasi stok tidak sama")
        {
            $this->reset($id, $request->lokasi_stok);
            return view('admin.stok_opname.ubah', ['stok_opname' => $stokOpname, 'barangHasKadaluarsa' => $barangHasKadaluarsa, 'barang' => $barang, 'detail_stok_opname' => null])->with(['success' => 'Data transfer barang berhasil diubah. Silahkan lengkapi barang yang ingin dilakukan proses stok opname']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->reset($id, $request->lokasi_stok);

        $hapus = DB::table('stok_opname')
                    ->where('id', '=', $id)
                    ->delete();

        $deleteHistoryEdit = DB::table('history_edit')
                                ->where('edit_id', '=', $id)
                                ->delete();

        return redirect()->route('stok_opname.index')->with(['success' => 'Data stok opname berhasil dihapus']);

    }
}
