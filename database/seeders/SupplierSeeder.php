<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supplier')->delete();
        
        DB::table('supplier')->insert(
            [   
                'id'            => 1,  
                'nama'          => 'Lorem Ipsum',
                'alamat'        => 'Jl. Jalanan',
                'nomor_telepon' => '0811111111111',
                'jenis'         => 'Individu'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 2,  
                'nama'          => 'Iping Suping',
                'alamat'        => 'Jl. Katrok',
                'nomor_telepon' => '0822222222222',
                'jenis'         => 'Individu'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 3,  
                'nama'          => 'PT Supaya Jaya',
                'alamat'        => 'Jl. Medokan',
                'nomor_telepon' => '087923837928',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 4,  
                'nama'          => 'PT Terserah Elu',
                'alamat'        => 'Jl. Tenggilis',
                'nomor_telepon' => '0867362186321',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 5,  
                'nama'          => 'PT Mukjizat',
                'alamat'        => 'Jl. Jujurandum',
                'nomor_telepon' => '0836283621731',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 6,  
                'nama'          => 'UD Kelor Jaya',
                'alamat'        => 'Jl. Deket Sidoarjo',
                'nomor_telepon' => '0898877676867',
                'jenis'         => 'Perusahaan'
            ]
        );
    }

}
