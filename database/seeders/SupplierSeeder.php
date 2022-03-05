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
                'nama'          => 'House of Foods',
                'alamat'        => 'Jl. Ahmad Yani No. 9',
                'nomor_telepon' => '089165487699',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 2,  
                'nama'          => 'House of Drinks',
                'alamat'        => 'Jl. Cendrawasih No. 6',
                'nomor_telepon' => '086592731319',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 3,  
                'nama'          => 'Mulyono',
                'alamat'        => 'Jl. Keputih V No. 99',
                'nomor_telepon' => '0821776889435',
                'jenis'         => 'Individu'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 4,  
                'nama'          => 'Sudikin',
                'alamat'        => 'Jl. Mawar Kembang 90 No. 7',
                'nomor_telepon' => '0863516753111',
                'jenis'         => 'Individu'
            ]
        );
    }

}
