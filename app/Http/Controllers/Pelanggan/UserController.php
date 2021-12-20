<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show()
    {
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['profil' => $user, 'total_cart' => $total_cart]);
    }

    public function updateProfil(Request $request)
    {
        $foto = DB::table('users')->select('foto')->where('id', auth()->user()->id)->get();

        $newFileName = $foto[0]->foto != null ? $foto[0]->foto : null;

        // $numFiles = count(Storage::disk('public')->allFiles("images/profil"));

        // $newName = $numFiles+1;

        if($request->foto_baru != null)
        {
            $newFileName = "1.".$request->foto_baru->getClientOriginalExtension(); 

            $request->foto_baru->storeAs('public/images/profil/'.auth()->user()->id, $newFileName);
        }

        $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['nomor_telepon' => $request->nomor_telepon, 'foto' => $newFileName]);

        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        return redirect()->back()->with(['status', 'Data berhasil diubah']);
        // $status = "Data berhasil diubah";

        // return view('pelanggan.user_menu.user_menu', ['profil' => $user, 'status' => $status]);
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
