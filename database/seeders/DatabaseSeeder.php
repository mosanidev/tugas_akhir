<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            JenisBarangSeeder::class,
            KategoriBarangSeeder::class,
            MerekBarangSeeder::class,
            SupplierSeeder::class,
            BarangSeeder::class,
            AlamatSeeder::class,
            BarangHasKadaluarsaSeeder::class,
            CartSeeder::class,
            PembayaranSeeder::class,
            ShipperSeeder::class,
            PembelianSeeder::class,
            DetailPembelianSeeder::class,
            ReturPembelianSeeder::class,
            DetailReturPembelianSeeder::class,
            PeriodeDiskonSeeder::class,
            KonsinyasiSeeder::class,
            DetailKonsinyasiSeeder::class,
            PengirimanSeeder::class,
            MultiplePengirimanSeeder::class,
            PemesananSeeder::class,
            DetailPemesananSeeder::class,
            PenjualanSeeder::class,
            DetailPenjualanSeeder::class


        ]);
    
    }
}
