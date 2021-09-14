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
                'alamat'               => 'Jl. Tenggilis Mejoyo No. 6A',
                'kecamatan'            => 'Bubutan',
                'kode_pos'             => 60172,
                'kota_kabupaten'       => 'Surabaya',
                'provinsi'             => 'Jawa Timur',
                'users_id'             => 1,
                'alamat_utama'         => 1 
            ]
        );

        DB::table('alamat_pengiriman')->insert(
            [   
                'id'                   => 2,  
                'label'                => 'Kantor',
                'nama_penerima'        => 'Sudikin Sudikah',
                'nomor_telepon'        => '08123456789',
                'alamat'               => 'Jl. Bubutan No. 9' ,
                'kecamatan'            => 'Tenggilis Mejoyo',
                'kode_pos'             => 60292,
                'kota_kabupaten'       => 'Surabaya',
                'provinsi'             => 'Jawa Timur',
                'users_id'             => 1,
                'alamat_utama'         => 0 
            ]
        );

    }
}
