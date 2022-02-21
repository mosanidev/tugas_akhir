<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pemesanan')->delete();

        DB::table('pemesanan')->insert([
            'id' => 1,
            'nomor_nota' => 'N0001',
            'supplier_id' => 1,
            'tanggal' => '2022-02-10',
            'users_id' => 3,
            'perkiraan_tanggal_terima' => '2022-02-15',
            'tanggal_jatuh_tempo' => '2022-02-22',
            'diskon' => 0,
            'ppn' => 0,
            'metode_pembayaran' => 'Transfer bank',
            'status_bayar' => 'Belum lunas',
            'status' => 'Belum diterima di gudang',
            'total' => 10500
        ]);
    }
}
