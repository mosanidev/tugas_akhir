<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Validator;

class AdminKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawan = DB::table('users')->where('jenis', '=', 'Admin')->get();

        return view('admin.karyawan.index', ['karyawan' => $karyawan]);
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
        $rules = [
            'email'                 => 'unique:users',
            'nomor_telepon'         => 'unique:users'
        ];
  
        $messages = [
            'email.unique'              => 'Email sudah terdaftar',
            'nomor_telepon.unique'      => 'Nomor telepon sudah terdaftar'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $foto = isset($request->foto) ? $request->foto : '/images/profil/user_null.png';

        $insert = DB::table('users')->insert([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis' => 'Admin',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
            'foto' => $foto
        ]);

        if($insert)
        {
            return redirect()->back()->with(['success   ' => 'Data berhasil ditambahkan']);
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
        $karyawan = DB::table('users')
                    ->where('id', '=', $id)
                    ->get();

        return view('admin.karyawan.show', ['karyawan' => $karyawan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $karyawan = DB::table('users')->where('id', $id)->get();

        if($request->ajax())
        {
            return response()->json(['karyawan' => $karyawan]);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $update = DB::table('users')
                ->where('id', $id)
                ->update([
                    'password' => Hash::make($request->password_change)
                ]);

        if($update)
        {
            return redirect()->back()->with(['success' => 'Data berhasil diubah']);
        }
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
        $cek_nomor_telepon = DB::table('users')->select('nomor_telepon')->whereNotIn('id', [$id])->get();

        $cari = false;

        for($i=0; $i<count($cek_nomor_telepon); $i++)
        {
            if($request->nomor_telepon_edit == $cek_nomor_telepon[$i]->nomor_telepon)
            {
                $cari = true;
            }
        }
        
        if($cari)
        {
            return redirect()->back()->with(['error' => 'Data gagal diubah. Nomor telepon sudah ada']);
        }

        $foto = isset($request->foto_edit) ? $request->foto_edit : null;

        $update = DB::table('users')
                ->where('id', $id)
                ->update([
                    'nomor_telepon' => $request->nomor_telepon_edit,
                    'foto' => $foto
                ]);

        if($update)
        {
            return redirect()->back()->with(['success' => 'Data berhasil diubah']);
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
        $delete = DB::table('users')->where('id', $id)->delete();

        if($delete)
        {
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        }
    }
}
