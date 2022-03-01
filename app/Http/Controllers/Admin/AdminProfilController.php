<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminProfilController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->select('*')->where('id', '=', auth()->user()->id)->get();

        return view('admin.profil.index', ['profil' => $user]);
    }
}
