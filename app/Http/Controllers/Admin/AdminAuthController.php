<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm() 
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        $user = DB::table('users')->where('email', $data['email'])->get();

        if (count($user) == 0) // false
        {
            return redirect()->back()->with(['error' => 'Email belum terdaftar di sistem']);
        } 
        else if($user[0]->jenis == "Pelanggan") // false
        {
            return redirect()->back()->with(['error' => 'Mohon maaf anda tidak memiliki hak akses']);
        }
        else { // true

            Auth::attempt($data);
            
            if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
                
                return redirect()->route('home_admin');
      
            } else { // false
      
                // login fail
                return redirect()->back()->with(['error' => 'Email atau password salah']);
            }
        }
    }
}
