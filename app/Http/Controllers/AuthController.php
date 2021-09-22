<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use Session;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm() 
    {
        return view('auth.register');
    }

    public function showLoginForm() 
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $rules = [
            'nama_depan'            => 'min:3|max:35',
            'nama_belakang'         => 'min:3|max:35',
            'email'                 => 'unique:users,email',
            'password'              => 'min:8|same:re_password',
            'nomor_telepon'         => 'min:10|unique:users,nomor_telepon'
        ];
  
        $messages = [
            'nama_depan.min'            => 'Nama depan minimal 3 karakter',
            'nama_depan.max'            => 'Nama depan maksimal 35 karakter',
            'nama_belakang.min'         => 'Nama belakang minimal 3 karakter',
            'nama_belakang.max'         => 'Nama belakang maksimal 35 karakter',
            'email.unique'              => 'Email sudah terdaftar',
            'nomor_telepon.min'         => 'Nomor telepon minimal 10 digit',
            'nomor_telepon.unique'      => 'Nomor telepon sudah terdaftar',
            'password.same'             => 'Password yang anda ulangi tidak sama',
            'password.min'              => 'Password minimal 8 digit'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        // $simpan = DB::table('users')->insert([
        //             'nama'  => ucwords(strtolower($request->nama)),
        //             'email' => strtolower($request->email),
        //             'password' => Hash::make($request->password),
        //             'jenis_kelamin' => $request->jenis_kelamin,
        //             'tanggal_lahir' => $request->tanggal_lahir,
        //             'nomor_telepon' => $request->nomor_telepon,
        //             'jenis' => 'Pelanggan',
        //             'status_verifikasi_anggota' =>  'Unverified'
        //         ]);

        $user = new User;
        $user->nama_depan = ucwords(strtolower($request->nama_depan));
        $user->nama_belakang = ucwords(strtolower($request->nama_belakang));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->jenis = 'Pelanggan';
        $user->status_verifikasi_anggota = 'Unverified';

        $simpan = $user->save();
        
        if($simpan){
            Session::flash('success', 'Pendaftaran akun berhasil! Silahkan masuk');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Pendaftaran akun gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function login(Request $request) 
    {
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        $user = DB::table('users')->where('email', $data['email'])->get();

        if (count($user) == 0)
        {
            Session::flash('error', 'Email belum terdaftar di sistem');
            return redirect()->route('login');

        } else {

            Auth::attempt($data);
            
            if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
                
                // jika session cart tidak kosong, maka isi table cart dengan session cart
                if (session()->get('cart') != null)
                {
                    foreach(session()->get('cart') as $item)
                    {
                        $insert = DB::table('cart')->insert([
                            'barang_id' => $item->barang_id,
                            'kuantitas' => $item->kuantitas,
                            'subtotal' => $item->subtotal,
                            'total' => 0,
                            'users_id' => auth()->user()->id
                        ]);
                    }

                    $total = DB::table('cart')->select(DB::raw('SUM(subtotal) as total'))->where('users_id', '=', auth()->user()->id)->get();

                    $update_total_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['total' => $total[0]->total]);

                    session()->forget('cart'); 
                }

                //Login Success
                if($user[0]->jenis == "Admin")
                {
                    return redirect()->route('home_admin');
                }
                else if ($user[0]->jenis == "Pelanggan")
                {
                    return redirect()->route('home');
                }
      
            } else { // false
      
                //Login Fail
                Session::flash('error', 'Email atau password salah');
                return redirect()->route('login');
            }
        }
       
    }
    
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }
}
