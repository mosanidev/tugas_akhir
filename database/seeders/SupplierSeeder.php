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
                'nama'          => 'Indogrosir',
                'alamat'        => 'Jl. Ahmad Yani No. 9',
                'nomor_telepon' => '089165487699',
                'jenis'         => 'Perusahaan'
            ]
        );

        DB::table('supplier')->insert(
            [   
                'id'            => 2,  
                'nama'          => 'Cakrawala',
                'alamat'        => 'Jl. Rungkut No. 11',
                'nomor_telepon' => '0895355458900',
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
    }

}
