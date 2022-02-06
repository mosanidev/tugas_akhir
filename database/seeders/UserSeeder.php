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
           'nama_depan' => 'Customer',
           'nama_belakang' => '1',
           'email' => 'customer1@customer.com', 
           'jenis_kelamin' => 'Laki-laki',
           'nomor_telepon' => '08123456789', 
           'jenis' => 'Pelanggan',
           'status_verifikasi_anggota' => 'Unverified',
           'tanggal_lahir' => '2000-01-20',
           'password' => Hash::make('kopkarubaya')
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'nama_depan' => 'Customer',
            'nama_belakang' => '2',
            'email' => 'customer2@customer.com', 
            'jenis_kelamin' => 'Laki-laki',
            'nomor_telepon' => '08198765432', 
            'jenis' => 'Pelanggan',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1995-01-20',
            'password' => Hash::make('kopkarubaya')
         ]);

         DB::table('users')->insert([
            'id' => 3,
            'nama_depan' => 'Admin',
            'nama_belakang' => '1',
            'email' => 'admin1@admin.com', 
            'jenis_kelamin' => 'Perempuan',
            'nomor_telepon' => '087288300078', 
            'jenis' => 'Admin',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1992-01-20',
            'password' => Hash::make('kopkarubaya')
         ]);

         DB::table('users')->insert([
            'id' => 4,
            'nama_depan' => 'Manajer',
            'nama_belakang' => '1',
            'email' => 'manajer1@manajer.com', 
            'jenis_kelamin' => 'Perempuan',
            'nomor_telepon' => '93189831', 
            'jenis' => 'Manajer',
            'status_verifikasi_anggota' => 'Unverified',
            'tanggal_lahir' => '1992-01-20',
            'password' => Hash::make('kopkarubaya')
         ]);

         DB::table('users')->insert([
            'id' => 5,
            'nama_depan' => 'Anggota',
            'nama_belakang' => 'Kopkar',
            'email' => 'anggota@kopkar.com', 
            'jenis_kelamin' => 'Perempuan',
            'nomor_telepon' => '087654392819', 
            'jenis' => 'Anggota_Kopkar',
            'status_verifikasi_anggota' => 'Verified',
            'nomor_anggota' => '160416154',
            'tanggal_lahir' => '1992-03-07',
            'password' => Hash::make('kopkarubaya')
         ]);
    }
}
