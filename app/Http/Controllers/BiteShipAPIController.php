<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;

class BiteShipAPIController extends Controller
{
    public function getDoubleArea($kecamatan) 
    {
        $kecamatan = trim(str_replace(" ", "+", $kecamatan));

        $response = Http::withHeaders([
                'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI'
                ])->get("https://api.biteship.com/v1/maps/areas?countries=ID&input=$kecamatan&type=double");
                
        return $response->body(); 
    }

    public function getSingleArea($kecamatan) 
    {
        $kecamatan = trim(str_replace(" ", "+", $kecamatan));

        $response = Http::withHeaders([
                'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI'
                ])->get("https://api.biteship.com/v1/maps/areas?countries=ID&input=$kecamatan&type=single");
                
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

    public function createOrder(Request $request)
    {
        $r = [
            "shipper_contact_name"=>"Amir",
            "shipper_contact_phone"=>"081277882932",
            "shipper_contact_email"=>"biteship@test.com",
            "shipper_organization"=>"Biteship Org Test",
            "origin_contact_name"=>"Amir",
            "origin_contact_phone"=>"081740781720",
            "origin_address"=>"Plaza Senayan, Jalan Asia Afrika",
            "origin_note"=>"Deket pintu masuk STC",
            "origin_postal_code"=>12440,
            "origin_coordinate" => [
                "latitude"=>-6.2253114,
                "longitude"=>106.7993735
            ],
            "destination_contact_name"=>"John Doe",
            "destination_contact_phone"=>"08170032123",
            "destination_contact_email"=>"jon@test.com",
            "destination_address"=>"Lebak Bulus MRT",
            "destination_postal_code"=>12950,
            "destination_note"=>"Near the gas station",
            "destination_coordinate"=> [
                "latitude"=>-6.28927,
                "longitude"=>106.77492000000007
            ],
            "destination_cash_on_delivery"=>500000,
            "destination_cash_on_delivery_type"=>"7_days",
            "courier_company"=>"grab",
            "courier_type"=>"instant",
            "courier_insurance"=>500000,
            "delivery_type"=>"later",
            "delivery_date"=>"2019-09-24",
            "delivery_time"=>"12=>00",
            "order_note"=> "Please be carefull",
            "metadata"=> [],
            "items"=> [
                [
                    "id" => "5db7ee67382e185bd6a14608",
                    "name" => "Black L",
                    "image" => "",
                    "description" => "White Shirt",
                    "value" => 165000,
                    "quantity" => 1,
                    "height" => 10,
                    "length" => 10,
                    "weight" => 200,
                    "width" =>10
                ]
            ]
        ];

        // dd($r);

        $response = Http::withHeaders([
            'authorization' => 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoidGVzdGluZyIsInVzZXJJZCI6IjYxMTRhZTM3MzNmNGMxMDQzMWNkODM5MSIsImlhdCI6MTYzMjUzNDI1MX0.EmLbRbmLbhqPHi21AzkvuLxl6uP1IvUFfrC4IPh7DkI',
            ])->post("https://api.biteship.com/v1/orders", [
                "shipper_contact_name"=>"Amir",
                "shipper_contact_phone"=>"081277882932",
                "shipper_contact_email"=>"biteship@test.com",
                "shipper_organization"=>"Biteship Org Test",
                "origin_contact_name"=>"Amir",
                "origin_contact_phone"=>"081740781720",
                "origin_address"=>"Plaza Senayan, Jalan Asia Afrik...",
                "origin_note"=>"Deket pintu masuk STC",
                "origin_postal_code"=>12440,
                "origin_coordinate" => [
                    "latitude"=>-6.2253114,
                    "longitude"=>106.7993735
                ],
                "destination_contact_name"=>"John Doe",
                "destination_contact_phone"=>"08170032123",
                "destination_contact_email"=>"",
                "destination_address"=>"Lebak Bulus MRT...",
                "destination_postal_code"=>12950,
                "destination_note"=>"Near the gas station",
                "destination_coordinate"=> [
                    "latitude"=>-6.28927,
                    "longitude"=>106.77492000000007
                ],
                "courier_company"=>"jne",
                "courier_type"=>"reg",
                "delivery_type"=>"later",
                "delivery_date"=>"2022-01-26",
                "delivery_time"=>"22:00",
                "order_note"=> "Please be carefull",
                "metadata"=> [],
                "items"=> [
                    [
                        "id" => "5db7ee67382e185bd6a14608",
                        "name" => "Black L",
                        "image" => "",
                        "description" => "White Shirt",
                        "value" => 165000,
                        "quantity" => 1,
                        "weight" => 200
                    ]
                ]
            ]);

        dd($response->body());
    }
    
}

