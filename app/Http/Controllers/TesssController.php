<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesssController extends Controller
{
    public function tescon()
    {
        $data["tanggal"]=date("d-M-Y H:i:s");
        return view('pelanggan.tescon',$data);
    }
}
