<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
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
        if(Auth::check())
        {
            return redirect()->route('home');
        }
        else 
        {
            return view('pelanggan.auth.register');
        }
    }

    public function showLoginForm() 
    {
        if(Auth::check())
        {
            return redirect()->route('home');
        }
        else 
        {
            return view('pelanggan.auth.login');
        }
    }

    public function register(Request $request)
    {
        $nomor_anggota = isset($request->nomor_anggota) ? $request->nomor_anggota : null;

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
  
        $simpan = null;

        if($nomor_anggota == null)
        {
            $simpan = DB::table('users')->insert([
                'nama_depan'  => ucwords(strtolower($request->nama_depan)),
                'nama_belakang'  => ucwords(strtolower($request->nama_belakang)),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nomor_telepon' => $request->nomor_telepon,
                'jenis' => 'Pelanggan',
                'status_verifikasi_anggota' =>  'Unverified'
            ]);
        }
        else 
        {
            $simpan = DB::table('users')->insert([
                'nama_depan'  => ucwords(strtolower($request->nama_depan)),
                'nama_belakang'  => ucwords(strtolower($request->nama_belakang)),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nomor_telepon' => $request->nomor_telepon,
                'nomor_anggota' => $nomor_anggota,
                'jenis' => 'Anggota_Kopkar',
                'status_verifikasi_anggota' =>  'Verified'
            ]);
        }
        
        if($simpan){
            Session::flash('success', 'Pendaftaran akun berhasil! Silahkan masuk');
            return redirect()->route('pelanggan.login')->with(['success' => 'Pendaftaran akun berhasil silahkan login']);
        } else {
            Session::flash('errors', ['' => 'Pendaftaran akun gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('pelanggan.register');
        }
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

        } else if ($user[0]->jenis != "Pelanggan")  // false
        {
            return redirect()->back()->with(['error' => 'Mohon maaf anda tidak memiliki hak akses']);

        } else { // true

            Auth::attempt($data);
            
            if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
                
                $this->addCartSessionToDatabase();

                return redirect()->route('home')->with(['success' => 'Selamat Datang '.$user[0]->nama_depan.' '.$user[0]->nama_belakang]);
      
            } else { // false
      
                // login fail
                return redirect()->back()->with(['error' => 'Email atau password salah']);
            }
        }
       
    }
    
    public function addCartSessionToDatabase()
    {
        // jika session cart tidak kosong, maka isi table cart dengan session cart
        if (session()->get('cart') != null)
        {
            foreach(session()->get('cart') as $item)
            {       
                // cek barang di database yang sama dengan di session                  
                $barang = DB::table('cart')->select('kuantitas')->where('users_id', '=', auth()->user()->id)->where('barang_id', '=', $item->barang_id)->get();

                // jika barangnya ada ambil  
                $kuantitas = isset($barang[0]->kuantitas) ? $barang[0]->kuantitas : 0;

                $insert = DB::table('cart')->upsert([
                    [
                        'barang_id' => $item->barang_id,
                        'kuantitas' => $kuantitas + $item->kuantitas,
                        'subtotal' => $item->subtotal,
                        'total' => 0,
                        'users_id' => auth()->user()->id
                    ]
                ], ['barang_id', 'users_id'], ['kuantitas', 'subtotal', 'total']);

            }

            $total = DB::table('cart')->select(DB::raw('SUM(subtotal) as total'))->where('users_id', '=', auth()->user()->id)->get();

            $update_total_cart = DB::table('cart')->where('users_id', '=', auth()->user()->id)->update(['total' => $total[0]->total]);

            session()->forget('cart'); 
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('pelanggan.login');
    }
}
