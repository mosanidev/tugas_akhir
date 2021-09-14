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
                'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoia3VyaXIiLCJ1c2VySWQiOiI2MTE0YWUzNzMzZjRjMTA0MzFjZDgzOTEiLCJpYXQiOjE2Mjg3Njk0NzV9.2J2MdLaOUGyrzi16xJkyxuxdrTBQYwPNNA08Xu-JmI4'
                ])->get("https://api.biteship.com/v1/maps/areas?countries=ID&input=$kecamatan&type=double");
                
        return $response->body(); 
    }

    public function getPostalCode($areaID)
    {
        $response = Http::withHeaders([
                    'authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoia3VyaXIiLCJ1c2VySWQiOiI2MTE0YWUzNzMzZjRjMTA0MzFjZDgzOTEiLCJpYXQiOjE2Mjg3Njk0NzV9.2J2MdLaOUGyrzi16xJkyxuxdrTBQYwPNNA08Xu-JmI4'
                    ])->get("https://api.biteship.com/v1/maps/areas/$areaID");
                
        return $response->body(); 
    }   
}

