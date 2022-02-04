<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Http;

class AdminPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = DB::table('detail_penjualan')
                        ->select('penjualan.nomor_nota', 'pengiriman.nomor_resi', 'penjualan.tanggal as tanggal_jual', 'penjualan.status_jual','pengiriman.status_pengiriman', 'penjualan.metode_transaksi', 'shipper.nama as pengirim', 'pengiriman.status_pengiriman', DB::raw("CONCAT(shipper.nama, ' ', pengiriman.jenis_pengiriman) as pengiriman"), 'pengiriman.tarif as tarif_pengiriman', 'multiple_pengiriman.pengiriman_id as pengiriman_id', 'penjualan.id as penjualan_id', 'multiple_pengiriman.alamat_pengiriman_id', DB::raw("CONCAT(users.nama_depan, ' ', users.nama_belakang) as pelanggan"), "users.id as pelanggan_id", "pengiriman.id_pengiriman", "pengiriman.waktu_jemput", "pengiriman.status")
                        ->whereNotNull('detail_penjualan.pengiriman_id')
                        ->whereNotNull('detail_penjualan.alamat_pengiriman_id')
                        ->where('penjualan.status_jual', '=', 'Pesanan sudah dibayar')
                        ->where('penjualan.jenis', '=', 'Online')
                        ->whereNotIn("penjualan.metode_transaksi", ['Ambil di toko'])
                        ->join('penjualan', 'detail_penjualan.penjualan_id', '=', 'penjualan.id')
                        ->join('users', 'penjualan.users_id', '=', 'users.id')
                        ->join('multiple_pengiriman', 'detail_penjualan.pengiriman_id', '=', 'multiple_pengiriman.pengiriman_id')
                        ->join('pengiriman', 'multiple_pengiriman.pengiriman_id', '=', 'pengiriman.id')
                        ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                        ->join('shipper', 'shipper.kode_shipper', '=', 'pengiriman.kode_shipper')
                        ->groupBy('detail_penjualan.alamat_pengiriman_id')
                        ->get();

        /*
            nomor_nota
            tanggal
            status
            pengirim
            kode_jenis_pengiriman
            jenis_pengiriman
            alamt tujuan
            estimasi tiba
            tarif pengiriman
            total berat

            nama_penerima
            nomor_telepon
            email_penerima
            alamat
            kode pos
            latitude 
            longitude

            barang yang dijual
        */

        // $penjualan = DB::table('detail_penjualan')->get();

        return view('admin.pengiriman.index', ['penjualan' => $penjualan]);
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

    public function changeDraftToComplete(Request $request, $id)
    {
        $response = Http::withHeaders([
            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
            ])->post("https://api.biteship.com/v1/orders/$request->id_pengiriman/confirm");

        $result = json_decode($response->body(), true);

        if($result['success'] == false)
        {
            return redirect()->back()->with(['error' => 'Terjadi kesalahan : '.$result['error']]);
        }
        else if($result['success'] == true)
        {
            $update = DB::table('pengiriman')
                    ->where('id', $id)
                    ->update([
                        'nomor_resi' => $result['courier']['waybill_id'],
                        'status_pengiriman' => 'Sudah dikonfirmasi atas penjemputan kurir',
                        'status' => 'Complete'
                    ]);

            return redirect()->route('pengiriman.index')->with(['success' => 'Data pengiriman dikonfirmasi']);
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
        $tanggalJemput = \Carbon\Carbon::parse($request->waktu_jemput)->format("Y-m-d");
        $jamJemput = \Carbon\Carbon::parse($request->waktu_jemput)->format("H:i");

        $alamat_pengiriman = DB::table('alamat_pengiriman')
                                ->select('alamat_pengiriman.nama_penerima',
                                         'alamat_pengiriman.nomor_telepon', 
                                         'alamat_pengiriman.alamat', 
                                         'alamat_pengiriman.kode_pos', 
                                         'alamat_pengiriman.longitude', 
                                         'alamat_pengiriman.latitude')
                                ->join('users', 'alamat_pengiriman.users_id', '=', 'users.id')
                                ->where('alamat_pengiriman.id', '=', $request->alamat_pengiriman_id)
                                ->get();

        $pengiriman = DB::table('pengiriman')
                        ->select('pengiriman.kode_shipper', 'pengiriman.kode_jenis_pengiriman')
                        ->where('pengiriman.id', '=', $request->pengiriman_id)
                        ->get();

        $params = [
            "shipper_contact_name"=>"Admin",
            "shipper_contact_phone"=>"081277882932",
            "shipper_contact_email"=>"admin@kopkar.com",
            "shipper_organization"=>"Kopkar Ubaya",
            "origin_contact_name"=>"Admin",
            "origin_contact_phone"=>"081740781720",
            "origin_address"=>"Universitas Surabaya, Jl. Raya Kalirungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293",
            "origin_note"=>"Di dalam Universitas Surabaya, di Lapangan",
            "origin_postal_code"=>60293,
            "origin_coordinate" => [
                "latitude"=>-7.320228755327554,
                "longitude"=>112.76752962946058
            ],
            "destination_contact_name"=> $alamat_pengiriman[0]->nama_penerima,
            "destination_contact_phone"=> $alamat_pengiriman[0]->nomor_telepon,
            "destination_contact_email"=>"",
            "destination_address"=>$alamat_pengiriman[0]->alamat,
            "destination_postal_code"=>$alamat_pengiriman[0]->kode_pos,
            "destination_note"=>"",
            "destination_coordinate"=> [
                "latitude"=>$alamat_pengiriman[0]->latitude,
                "longitude"=>$alamat_pengiriman[0]->longitude
            ],
            "courier_company"=>$pengiriman[0]->kode_shipper,
            "courier_type"=>$pengiriman[0]->kode_jenis_pengiriman,
            "delivery_type"=>"later",
            "delivery_date"=>$tanggalJemput,
            "delivery_time"=>$jamJemput,
            "order_note"=> "Please be careful",
            "metadata"=> [],
            "items" => []
        ];

        $detail_penjualan = DB::table('detail_penjualan')
                            ->select('barang.kode', 
                                     'barang.nama', 
                                     'barang.deskripsi', 
                                     'barang.harga_jual', 
                                     'detail_penjualan.kuantitas', 
                                     'barang.berat')
                            ->where('detail_penjualan.penjualan_id', '=', $request->penjualan_id)
                            ->where('detail_penjualan.pengiriman_id', '=', $request->pengiriman_id)
                            ->where('detail_penjualan.alamat_pengiriman_id', '=', $request->alamat_pengiriman_id)
                            ->join('barang', 'detail_penjualan.barang_id', '=', 'barang.id')
                            ->get()
                            ->toArray();
        $items = [];
        for($i = 0; $i < count($detail_penjualan); $i++)
        {
            $push = [
                "id" => $detail_penjualan[$i]->kode,
                "name" => $detail_penjualan[$i]->nama,
                "image" => "",
                "description" =>  $detail_penjualan[$i]->deskripsi,
                "value" =>  $detail_penjualan[$i]->harga_jual,
                "quantity" =>  $detail_penjualan[$i]->kuantitas,
                "height" =>  10,
                "length" =>  10,
                "weight" =>  $detail_penjualan[$i]->berat,
                "width" => 10
            ];

            array_push($items, $push);
        }

        array_push($params['items'], $items);

        $response = Http::withHeaders([
            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
            ])->post("https://api.biteship.com/v1/orders", $params);

        $result = json_decode($response->body(), true);

        if($result['success'] == false)
        {
            return redirect()->back()->with(['error' => 'Terjadi kesalahan : '.$result['error']]);
        }
        else if($result['success'] == true)
        {
            $update = DB::table('pengiriman')
                        ->where('id', '=', $request->pengiriman_id)
                        ->update([
                            'id_pengiriman' => $result['id'],
                            'status_pengiriman' => 'Menunggu konfirmasi penjemputan kurir',
                            'waktu_jemput' => $request->waktu_jemput
                            // 'catatan_untuk_kurir' => $request->catatan_untuk_kurir
                        ]);

            return redirect()->route('pengiriman.index')->with(['success' => 'Data pengiriman berhasil disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
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
        $tanggalJemput = \Carbon\Carbon::parse($request->waktu_jemput)->format("Y-m-d");
        $jamJemput = \Carbon\Carbon::parse($request->waktu_jemput)->format("H:i");

        $response = Http::withHeaders([
            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
            ])->post("https://api.biteship.com/v1/orders/$request->id_pengiriman", [
                "delivery_date" => $tanggalJemput,
                "delivery_time" => $jamJemput

            ]);

        $result = json_decode($response->body(), true);

        if($result['success'] == false)
        {
            return redirect()->route('pengiriman.index')->with(['error' => 'Terjadi kesalahan : '.$result['error']]);
        }
        else if($result['success'] == true)
        {
            return redirect()->route('pengiriman.index')->with(['success' => 'Data pengiriman berhasil diubah']);
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
        $id_pengiriman = $request->id_pengiriman;

        $response = Http::withHeaders([
            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
            ])->delete("https://api.biteship.com/v1/orders/$id_pengiriman");

        $result = json_decode($response->body(), true);

        if($result['success'] == false)
        {
            return redirect()->route('pengiriman.index')->with(['error' => 'Terjadi kesalahan : '.$result['error']]);
        }
        else if($result['success'] == true)
        {
            $update = DB::table('pengiriman')
                        ->where('id', '=', $id)
                        ->update([
                            'id_pengiriman' => NULL,
                            'waktu_jemput' => NULL,
                            'status_pengiriman' => NULL 
                        ]);

            return redirect()->route('pengiriman.index')->with(['success' => 'Data pengiriman berhasil dibatalkan']);
        }
    }
}
