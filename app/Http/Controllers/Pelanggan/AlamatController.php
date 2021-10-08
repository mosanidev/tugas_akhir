<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->orderBy('alamat_utama', 'desc')->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan..user_menu.user_menu', ['alamat'=>$alamat, 'total_cart'=>$total_cart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alamat = DB::table('alamat_pengiriman')->where('users_id', '=', auth()->user()->id)->get();

        $alamat_utama = count($alamat) == 0 ? 1 : 0;

        $insert_alamat = DB::table('alamat_pengiriman')->insert([
            'label' => $request->label_alamat,
            'nama_penerima' => $request->nama_penerima,
            'nomor_telepon' => $request->nomor_telepon,
            'kecamatan' => explode(',', $request->kecamatan)[0],
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
            'alamat_utama' => $alamat_utama,
            'kota_kabupaten' => explode(',', $request->kecamatan)[1],
            'provinsi' => explode(',', $request->kecamatan)[2],
            'users_id' => auth()->user()->id
        ]);

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->orderBy('alamat_utama', 'desc')->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return redirect()->back()->with(['alamat'=>$alamat, 'total_cart'=>$total_cart]);
    }

    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alamat = DB::table('alamat_pengiriman')->select('*')->where('id', '=', $id)->where('users_id', '=', auth()->user()->id)->get();

        return response()->json(['alamat'=>$alamat[0]]);
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
        $alamat = DB::table('alamat_pengiriman')->where('id', $id)->update(['label' => $request->label, 'alamat' => $request->alamat, 'nama_penerima' => $request->nama_penerima, 'nomor_telepon' => $request->nomor_telepon, 'kecamatan' => $request->kecamatan, 'kode_pos' => $request->kode_pos, 'kota_kabupaten' => $request->kota_kabupaten, 'provinsi' => $request->provinsi, 'users_id' => auth()->user()->id]);

        return response()->json(['status'=>$alamat]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alamat = DB::table('alamat_pengiriman')->where('id', '=', $id)->delete();

        return response()->json(['status'=>$alamat]);
    }

    public function pickMainAddress(Request $request)
    {
        $alamat_lain = DB::table('alamat_pengiriman')->where('users_id', auth()->user()->id)->update(['alamat_utama' => 0]);

        $alamat_utama = DB::table('alamat_pengiriman')->where('id', $request->alamat_id)->update(['alamat_utama' => 1]);
    
        return redirect()->back();
    }

    // public function showAnotherAddress($id)
    // {
    //     $alamat_lain = DB::table('cart')->select('alamat_pengiriman.*')->join('alamat_pengiriman', 'cart.alamat_pengiriman_id', '=', 'alamat_pengiriman.id')->where('cart.barang_id', '=', $id)->where('cart.users_id', '=', auth()->user()->id)->get();
        
    //     dd($alamat_lain);
    //     // // query problem
    //     // $alamat_lain = DB::table('alamat_pengiriman')->where('users_id', '=', auth()->user()->id)->whereNotIn('id', [$id_alamat])->get();

    //     // $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();

    //     return response()->json(['alamat_lain'=>$alamat_lain]);
    //     // return view('pelanggan.order.multiple_shipment', ['cart'=>$cart, 'alamat'=>$alamat, 'alamat_lain' => $alamat_lain]);
    // }

    public function showAnotherAddress(Request $request)
    {
        // $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->whereNotIn('id', [$request->alamat])->get();

        $alamat = DB::table('alamat_pengiriman')->select('*')->where('users_id', '=', auth()->user()->id)->get();


        return response()->json(['alamat'=>$alamat]);

    }

    public function digitTitikAlamat(Request $request)
    {
        $update_titik_alamat = DB::table('alamat_pengiriman')->where('id', $request->id_titik_alamat)->update(['latitude' => $request->latitude, 'longitude' => $request->longitude]);

        return redirect()->back();
    }

    public function addMultipleAddress(Request $request)
    {
        $update = DB::table('cart')->where('users_id', auth()->user()->id)->update(['alamat_pengiriman_id' => $request->alamat_pengiriman_id]);

    }

}
