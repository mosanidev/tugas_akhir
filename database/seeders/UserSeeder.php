<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
           'id' => 1,
           'nama_depan' => 'Sudikin',
           'nama_belakang' => 'Sudikah',
           'email' => 'sudikin@hotmail.com', 
           'jenis_kelamin' => 'Laki-laki',
           'nomor_telepon' => '08123456789', 
           'jenis' => 'Pelanggan',
           'status_verifikasi_anggota' => 'Unverified',
           'tanggal_lahir' => '2000-01-20',
           'password' => Hash::make('inthesky')
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'nama_depan' => 'Nelson',
            'nama_belakang' => 'Jimun',
            'email' => 'nelsonjimun@hotmail.com', 
            'jenis_kelamin' => 'Laki-laki',
            'nomor_telepon' => '08198765432', 
            'jenis' => 'Pelanggan',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1995-01-20',
            'password' => Hash::make('inthesky')
         ]);

         DB::table('users')->insert([
            'id' => 3,
            'nama_depan' => 'Sri',
            'nama_belakang' => 'Rahayu',
            'email' => 'srirahayu@hotmail.com', 
            'jenis_kelamin' => 'Perempuan',
            'nomor_telepon' => '872883', 
            'jenis' => 'Admin',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1992-01-20',
            'password' => Hash::make('inthesky')
         ]);

         DB::table('users')->insert([
            'id' => 4,
            'nama_depan' => 'Kristanti',
            'nama_belakang' => 'Putri',
            'email' => 'kristatnti.putri@hotmail.com', 
            'jenis_kelamin' => 'Perempuan',
            'nomor_telepon' => '93189831', 
            'jenis' => 'Manajer',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1992-01-20',
            'password' => Hash::make('inthesky')
         ]);
    }
}
