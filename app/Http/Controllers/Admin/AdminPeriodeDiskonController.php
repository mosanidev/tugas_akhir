<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminPeriodeDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode_diskon = DB::table('periode_diskon')->get();

        return view('admin.periode_diskon.index', ['periode_diskon' => $periode_diskon]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periode_diskon = DB::table('periode_diskon')->get();

        $barangDiskon = DB::table('barang')
                            ->select('barang.id', 'barang.kode', 'barang.nama')
                            ->get();
        
        return view('admin.periode_diskon.tambah', ['periode_diskon' => $periode_diskon, 'barangDiskon' => $barangDiskon]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idPeriodeDiskon = DB::table('periode_diskon')
                                ->insertGetId([
                                    'tanggal_dimulai' => $request->tanggal_dimulai,
                                    'tanggal_berakhir' => $request->tanggal_berakhir,
                                    'keterangan' => $request->keterangan
                                ]);
        
        $diskonBarang = json_decode($request->diskon_barang, true);

        for($i = 0; $i < count((array) $diskonBarang); $i++)
        {
            $updateBarang = DB::table('barang')
                            ->where('id', $diskonBarang[$i]['barang_id'])
                            ->update([
                                'periode_diskon_id' => $idPeriodeDiskon,
                                'diskon_potongan_harga' => $diskonBarang[$i]['barang_diskon']
                            ]);
        }

        return redirect()->route('periode_diskon.index')->with(['success' => 'Data periode diskon berhasil bertambah']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periode_diskon = DB::table('periode_diskon')->where('id', '=', $id)->get();
        $barang_diskon = DB::table('barang')->where('periode_diskon_id', '=', $id)->get();

        return view('admin.periode_diskon.lihat', ['periode_diskon' => $periode_diskon, 'barang_diskon'=>$barang_diskon ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode_diskon = DB::table('periode_diskon')
                            ->where('id', '=', $id)->get();

        $barang_periode_diskon = DB::table('barang')
                                    ->where('periode_diskon_id', '=', $id)
                                    ->where('diskon_potongan_harga', '>', 0)
                                    ->get();

        return view('admin.periode_diskon.ubah', ['periode_diskon' => $periode_diskon, 'barang_periode_diskon' => $barang_periode_diskon]);
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
        $updateToDefault = DB::table('barang')
                            ->where('periode_diskon_id', '=', $id)
                            ->update([
                                'periode_diskon_id' => null,
                                'diskon_potongan_harga' => 0
                            ]);

        $update = DB::table('periode_diskon')
                    ->where('id', '=', $id)
                    ->update(['tanggal_dimulai'=>$request->tanggal_dimulai, 
                              'tanggal_berakhir'=>$request->tanggal_berakhir, 
                              'keterangan' => $request->keterangan]);

        $diskonBarang = json_decode($request->diskon_barang, true);

        for($i = 0; $i < count((array) $diskonBarang); $i++)
        {
            $updateBarang = DB::table('barang')
                            ->where('id', $diskonBarang[$i]['barang_id'])
                            ->update([
                                'periode_diskon_id' => $id,
                                'diskon_potongan_harga' => $diskonBarang[$i]['barang_diskon']
                            ]);
        }

        return redirect()->route('periode_diskon.index')->with(['success'=>'Data periode diskon berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ubah_barang = DB::table('barang')
                        ->where('periode_diskon_id', '=', $id)
                        ->update(['diskon_potongan_harga' => 0, 
                                  'periode_diskon_id' => null]);

        $delete = DB::table('periode_diskon')
                    ->where('id','=',$id)
                    ->delete();

        return redirect()->route('periode_diskon.index')->with(['success'=>'Data periode diskon berhasil dihapus']);
    }

}
