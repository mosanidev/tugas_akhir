<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barang')->delete();
        
        DB::table('barang')->insert(
            [   
                'id'                        => 1,  
                'kode'                      => '6CAABJ',
                'nama'                      => 'Cheetos Enak',
                'deskripsi'                 => 'Cheetos enak mantep betul asli gaes',
                'harga_jual'                => 80000, 
                'diskon_potongan_harga'     => 0,
                'satuan'                    => 'PCS',
                'jumlah_stok'               => 100,
                'tanggal_kadaluarsa'        => '2026-01-01',
                'berat'                     => 2,
                'label'                     => 'cheetos+enak',
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 2,
                'batasan_stok_minimal'      => 10,
                'perkiraan_stok_tambahan'   => 10
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 2,  
                'kode'                      => '90KIBL',
                'nama'                      => 'Chitato',
                'deskripsi'                 => 'Chitato enak mantep betul asli gaes',
                'harga_jual'                => 50000, 
                'diskon_potongan_harga'     => 0,
                'satuan'                    => 'PCS',
                'jumlah_stok'               => 9,
                'tanggal_kadaluarsa'        => '2030-01-01',
                'berat'                     => 2,
                'label'                     => 'chitato+enak',
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 2,
                'batasan_stok_minimal'      => 10,
                'perkiraan_stok_tambahan'   => 10
            ]
        );

        $koderand = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 3; $i<20; $i++)
        {
            DB::table('barang')->insert(
                [   
                    'id'                        => $i,  
                    'kode'                      => substr(str_shuffle($koderand), 21),
                    'nama'                      => str_shuffle($koderand),
                    'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                    'harga_jual'                => rand(2000, 70000), 
                    'diskon_potongan_harga'     => rand(500, 700),
                    'satuan'                    => 'PCS',
                    'jumlah_stok'               => rand(1, 200),
                    'tanggal_kadaluarsa'        => '2030-01-01',
                    'berat'                     => rand(1, 9),
                    'label'                     => substr(str_shuffle($koderand), 15),
                    'jenis_id'                  => 1,
                    'kategori_id'               => 2,
                    'merek_id'                  => rand(10, 15),
                    'batasan_stok_minimal'      => rand(9, 20),
                    'perkiraan_stok_tambahan'   => rand(9, 20)
                ]
            );
        }

        for ($i = 20; $i<41; $i++)
        {
            DB::table('barang')->insert(
                [   
                    'id'                        => $i,  
                    'kode'                      => substr(str_shuffle($koderand), 21),
                    'nama'                      => str_shuffle($koderand),
                    'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                    'harga_jual'                => rand(10000, 70000), 
                    'diskon_potongan_harga'     => rand(0, 0),
                    'satuan'                    => 'PCS',
                    'jumlah_stok'               => rand(1, 200),
                    'tanggal_kadaluarsa'        => '2030-01-01',
                    'berat'                     => rand(1, 9),
                    'label'                     => substr(str_shuffle($koderand), 15),
                    'jenis_id'                  => 2,
                    'kategori_id'               => 3,
                    'merek_id'                  => rand(16, 21),
                    'batasan_stok_minimal'      => rand(9, 20),
                    'perkiraan_stok_tambahan'   => rand(9, 20)
                ]
            );
        }

        for ($i = 41; $i<61; $i++)
        {
            DB::table('barang')->insert(
                [   
                    'id'                        => $i,  
                    'kode'                      => substr(str_shuffle($koderand), 21),
                    'nama'                      => str_shuffle($koderand),
                    'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                    'harga_jual'                => rand(10000, 70000), 
                    'diskon_potongan_harga'     => rand(500, 5000),
                    'satuan'                    => 'PCS',
                    'jumlah_stok'               => rand(1, 200),
                    'tanggal_kadaluarsa'        => '2030-01-01',
                    'berat'                     => rand(1, 9),
                    'label'                     => substr(str_shuffle($koderand), 15),
                    'jenis_id'                  => 3,
                    'kategori_id'               => 4,
                    'merek_id'                  => rand(22, 25),
                    'batasan_stok_minimal'      => rand(9, 20),
                    'perkiraan_stok_tambahan'   => rand(9, 20)
                ]
            );
        }

        for ($i = 61; $i<100; $i++)
        {
            DB::table('barang')->insert(
                [   
                    'id'                        => $i,  
                    'kode'                      => substr(str_shuffle($koderand), 21),
                    'nama'                      => str_shuffle($koderand),
                    'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                    'harga_jual'                => rand(15000, 100000), 
                    'diskon_potongan_harga'     => rand(3000, 7000),
                    'satuan'                    => 'PCS',
                    'jumlah_stok'               => rand(1, 200),
                    'tanggal_kadaluarsa'        => '2030-01-01',
                    'berat'                     => rand(1, 9),
                    'label'                     => substr(str_shuffle($koderand), 15),
                    'jenis_id'                  => 4,
                    'kategori_id'               => 5,
                    'merek_id'                  => rand(22, 25),
                    'batasan_stok_minimal'      => rand(9, 20),
                    'perkiraan_stok_tambahan'   => rand(9, 20)
                ]
            );
        }
    }
}
