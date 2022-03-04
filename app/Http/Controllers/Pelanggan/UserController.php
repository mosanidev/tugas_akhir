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
        $kategori = DB::table('kategori_barang')->get();
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();
        $total_cart = DB::table('cart')->select(DB::raw('count(*) as total_cart'))->where('users_id', '=', auth()->user()->id)->get();

        $jumlah_notif_belum_dilihat = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->where('notifikasi.status', '=', 'Belum dilihat')->get();
        
        $jumlah_notif = DB::table('notifikasi')->select(DB::raw('count(*) as jumlah_notif'))->where('notifikasi.users_id', '=', auth()->user()->id)->get();

        return view('pelanggan.user_menu.user_menu', ['profil' => $user, 'semua_kategori' => $kategori, 'total_cart' => $total_cart, 'jumlah_notif' => $jumlah_notif, 'jumlah_notif_belum_dilihat' => $jumlah_notif_belum_dilihat]);
    }

    public function updateProfil(Request $request)
    {
        $foto = DB::table('users')->select('foto')->where('id', auth()->user()->id)->get();

        $newFileName = $foto[0]->foto != null ? $foto[0]->foto : null;

        if(isset($request->foto_baru))
        {
            $newFileName = "1.".$request->foto_baru->getClientOriginalExtension(); 

            $request->foto_baru->storeAs('public/images/profil/'.auth()->user()->id, $newFileName);

            $newFilePath = "/images/profil/".auth()->user()->id."/".$newFileName;

            $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['nomor_telepon' => $request->nomor_telepon, 
                                  'foto' => $newFilePath]);
        }
        else if($request->keterangan_foto == "Foto dihapus")
        {
            $newFilePath = "/images/profil/user_null.png";

            $affected = DB::table('users')
                            ->where('id', auth()->user()->id)
                            ->update(['nomor_telepon' => $request->nomor_telepon, 
                                    'foto' => $newFilePath]);
        }
        else 
        {
            $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['nomor_telepon' => $request->nomor_telepon]); 
        }

        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        return redirect()->back()->with(['success' => 'Data profil berhasil diubah']);
    }

    public function changePassword(Request $request)
    {
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        $status = "";

        if(Hash::check($request->current_password, auth()->user()->password) == false)
        {
            $status = "Password saat ini yang anda isikan salah";

            return redirect()->back()->with(['error' => $status]);
        }
        else {
            if ($request->new_password == $request->re_new_password)
            {
                $affected = DB::table('users')
                        ->where('id', auth()->user()->id)
                        ->update(['password' => Hash::make($request->new_password)]);
                
                $status = "Password berhasil diubah";

                return redirect()->back()->with(['success' => $status]);
            }
            else
            {
                $status = "Ulangi password baru yang anda isikan dengan benar";

                return redirect()->back()->with(['error' => $status]);
            }
        }
    }
}
