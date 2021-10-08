<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;

class BiteShipAPIController extends Controller
{
    public function getArea($kecamatan) 
    {
        $kecamatan = trim(str_replace(" ", "+", $kecamatan));

        $response = Http::withHeaders([
                'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI'
                ])->get("https://api.biteship.com/v1/maps/areas?countries=ID&input=$kecamatan&type=double");
                
        return $response->body(); 
    }

    public function getPostalCode($areaID)
    {
        $response = Http::withHeaders([
                    'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI'
                    ])->get("https://api.biteship.com/v1/maps/areas/$areaID");
                
        return $response->body(); 
    }

    public function getRates(Request $request)
    {
        $response = Http::withHeaders([
                    'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
                    ])->post("https://api.biteship.com/v1/rates/couriers", [
                        "origin_postal_code" => $request->origin_postal_code,
                        "origin_latitude" => $request->origin_latitude,
                        "origin_longitude" => $request->origin_longitude,
                        "destination_latitude" => $request->destination_latitude,
                        "destination_longitude" => $request->destination_longitude,
                        "destination_postal_code" => $request->destination_postal_code,
                        "couriers" => $request->couriers,
                        "items" => $request->items
                    ]);
        
        // return response()->json(['response'=>$request->items]);
        return response()->json(['response'=>$response->body()]);

    }
    
}

