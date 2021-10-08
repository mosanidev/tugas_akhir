<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alamat_pengiriman')->delete();
        
        DB::table('alamat_pengiriman')->insert(
            [   
                'id'                   => 1,  
                'label'                => 'Rumah',
                'nama_penerima'        => 'Sudikin Sudikah',
                'nomor_telepon'        => '08123456789',
                'alamat'               => 'Jl. Darmo Permai Selatan V/No.91-A',
                'kecamatan'            => 'Dukuh Pakis',
                'kode_pos'             => 60226,
                'kota_kabupaten'       => 'Surabaya',
                'provinsi'             => 'Jawa Timur',
                'users_id'             => 1,
                'alamat_utama'         => 1,
                'latitude'             => -7.278287935959714,
                'longitude'            => 112.68976190829682,
            ]
        );

        DB::table('alamat_pengiriman')->insert(
            [   
                'id'                   => 2,  
                'label'                => 'Kantor',
                'nama_penerima'        => 'Sudikin Sudikah',
                'nomor_telepon'        => '08123456789',
                'alamat'               => 'Jl. Raya Janti No. 50 A' ,
                'kecamatan'            => 'Banguntapan',
                'kode_pos'             => 55198,
                'kota_kabupaten'       => 'Bantul',
                'provinsi'             => 'DI Yogyakarta',
                'users_id'             => 1,
                'alamat_utama'         => 0 
            ]
        );

    }
}
