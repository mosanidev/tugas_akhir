<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu', ['profil' => $user, 'total_cart' => $total_cart]);
    }

    public function updateProfil(Request $request)
    {
        $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['nomor_telepon' => $request->nomor_telepon]);

        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        $status = "Data berhasil diubah";

        return view('pelanggan.user_menu', ['profil' => $user, 'status' => $status]);
    }

    public function changePassword(Request $request)
    {
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        $status = "";

        if(Hash::check($request->current_password, auth()->user()->password) == false)
        {
            $status = "Maaf password saat ini yang anda isikan salah";
        }
        else {
            if ($request->new_password == $request->re_new_password)
            {
                $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['password' => Hash::make($request->new_password)]);
                
                $status = "Password berhasil diubah";
            }
            else
            {
                $status = "Maaf ulangi password baru yang anda isikan dengan benar";
            }
        }

        return redirect()->back()->with(['profil' => $user, 'status' => $status]);
    }
}
