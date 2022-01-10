<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

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
                'kode'                      => 'B001',
                'nama'                      => 'Nasi Kuning + Telur Asin Bungkus Plastik',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 9000, 
                'harga_jual'                => 12000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'barang_konsinyasi'         => 1,
                'berat'                     => 350,
                'jenis_id'                  => 1,
                'kategori_id'               => 1,
                'merek_id'                  => 1
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 2,  
                'kode'                      => 'B002',
                'nama'                      => 'Nasi Goreng + Suwir Ayam Bungkus Plastik',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 8000, 
                'harga_jual'                => 135000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                'barang_konsinyasi'         => 1,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'berat'                     => 20,
                'jenis_id'                  => 1,
                'kategori_id'               => 1,
                'merek_id'                  => 1
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 3,  
                'kode'                      => 'B003',
                'nama'                      => 'Nasi Ayam + Telur Dadar Bungkus Plastik',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 7000, 
                'harga_jual'                => 12000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                'barang_konsinyasi'         => 1,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'berat'                     => 350,
                'jenis_id'                  => 1,
                'kategori_id'               => 1,
                'merek_id'                  => 1
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 4,  
                'kode'                      => 'B004',
                'nama'                      => 'Dadar Goreng',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 2300, 
                'harga_jual'                => 3000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                'barang_konsinyasi'         => 1,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'berat'                     => 50,
                'jenis_id'                  => 1,
                'kategori_id'               => 23,
                'merek_id'                  => 1
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 5,  
                'kode'                      => 'B005',
                'nama'                      => 'Pisang Goreng',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1400, 
                'harga_jual'                => 3000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                'barang_konsinyasi'         => 1,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'berat'                     => 50,
                'jenis_id'                  => 1,
                'kategori_id'               => 23,
                'merek_id'                  => 1
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 6,  
                'kode'                      => 'B006',
                'nama'                      => 'Ote Ote',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1200, 
                'harga_jual'                => 3000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 0,
                'barang_konsinyasi'         => 1,
                // 'tanggal_kadaluarsa'        => Carbon::now()->format('Y-m-d'),
                'berat'                     => 50,
                'jenis_id'                  => 1,
                'kategori_id'               => 23,
                'merek_id'                  => 1
            ]
        );  

        DB::table('barang')->insert(
            [   
                'id'                        => 8,  
                'kode'                      => 'B008',
                'nama'                      => 'Chitato Snack Potato Chips Ayam Bumbu 168G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4500, 
                'harga_jual'                => 7900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 10,
                // 'tanggal_kadaluarsa'        => '2022-01-01',
                'berat'                     => 168,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 9,  
                'kode'                      => 'B009',
                'nama'                      => 'Chitato Snack Potato Chips Ayam Bumbu 168G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4500, 
                'harga_jual'                => 7900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-01-01',
                'berat'                     => 168,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 10,  
                'kode'                      => 'B0010',
                'nama'                      => 'Chitato Snack Potato Chips Sapi Panggang 168G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4500, 
                'harga_jual'                => 7900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-01-01',
                'berat'                     => 168,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 11,  
                'kode'                      => 'B011',
                'nama'                      => 'Chitato Snack Potato Chips Ayam Bumbu 55G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 3900, 
                'harga_jual'                => 8900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-01-01',
                'berat'                     => 55,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 12,  
                'kode'                      => 'B012',
                'nama'                      => 'Chitato Snack Potato Chips Sapi Panggang 55G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 5000, 
                'harga_jual'                => 8900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-06-07',
                'berat'                     => 55,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 13,  
                'kode'                      => 'B013',
                'nama'                      => 'Chitato Snack Potato Chips Ayam Barbeque 55G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 6000, 
                'harga_jual'                => 8900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-08-18',
                'berat'                     => 55,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 45
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 14,  
                'kode'                      => 'B014',
                'nama'                      => 'Cheetos Snack Ayam Jagung 15G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1100, 
                'harga_jual'                => 3100, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2022-09-25',
                'berat'                     => 15,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 46
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 15,  
                'kode'                      => 'B015',
                'nama'                      => 'Smax Snack Ring Keju 50G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 2200, 
                'harga_jual'                => 4500, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2023-02-12',
                'berat'                     => 50,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 47
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 16,  
                'kode'                      => 'B016',
                'nama'                      => 'Mentos Mint Roll 37G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 900, 
                'harga_jual'                => 3900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2021-12-30',
                'berat'                     => 37,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 42
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 17,  
                'kode'                      => 'B017',
                'nama'                      => 'Mentos Rainbow Roll 37G',
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1000, 
                'harga_jual'                => 3900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 50,
                // 'tanggal_kadaluarsa'        => '2021-10-30',
                'berat'                     => 37,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 42
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 18,  
                'kode'                      => 'B018',
                'nama'                      => "Fisherman's Candy Mint 25G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 8000, 
                'harga_jual'                => 17700, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-11-08',
                'berat'                     => 25,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 37
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 19,  
                'kode'                      => 'B019',
                'nama'                      => "Fisherman's Candy Honey & Lemon 25G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 9100, 
                'harga_jual'                => 17200, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-11-08',
                'berat'                     => 25,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 37
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 20,  
                'kode'                      => 'B020',
                'nama'                      => "Kopiko Permen Kopi",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 6600, 
                'harga_jual'                => 7900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-03-13',
                'berat'                     => 200,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 48
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 21,  
                'kode'                      => 'B021',
                'nama'                      => "Fisherman's Candy Honey & Lemon 25G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 9000, 
                'harga_jual'                => 17200, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-11-08',
                'berat'                     => 25,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 37
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 22,  
                'kode'                      => 'B022',
                'nama'                      => "Yupi Permen Stawberry",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4000, 
                'harga_jual'                => 7900, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-06-19',
                'berat'                     => 200,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 43
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 23,  
                'kode'                      => 'B023',
                'nama'                      => "Frozz Permen Mint 15G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 3000, 
                'harga_jual'                => 7700, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-06-19',
                'berat'                     => 15,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 44
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 24,  
                'kode'                      => 'B024',
                'nama'                      => "Frozz Permen Cherry Mint 15G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 3000, 
                'harga_jual'                => 7700, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-06-19',
                'berat'                     => 15,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 44
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 25,  
                'kode'                      => 'B025',
                'nama'                      => "Gofress Permen Tipis 15G",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4000, 
                'harga_jual'                => 6990, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2021-06-19',
                'berat'                     => 15,
                'jenis_id'                  => 1,
                'kategori_id'               => 3,
                'merek_id'                  => 40
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 26,  
                'kode'                      => 'B026',
                'nama'                      => "Baterai ABC AA Isi 4",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 4600, 
                'harga_jual'                => 8990, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2024-06-19',
                'berat'                     => 18,
                'jenis_id'                  => 7,
                'kategori_id'               => 19,
                'merek_id'                  => 39
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 27,  
                'kode'                      => 'B027',
                'nama'                      => "Baterai Eveready AAA",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 200, 
                'harga_jual'                => 1500, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2024-06-19',
                'berat'                     => 5,
                'jenis_id'                  => 7,
                'kategori_id'               => 19,
                'merek_id'                  => 38
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 28,  
                'kode'                      => 'B028',
                'nama'                      => "Baterai Eveready AA",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 300, 
                'harga_jual'                => 1500, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2024-06-19',
                'berat'                     => 5,
                'jenis_id'                  => 7,
                'kategori_id'               => 19,
                'merek_id'                  => 38
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 29,  
                'kode'                      => 'B029',
                'nama'                      => "Men's Biore Facewash",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 9000, 
                'harga_jual'                => 15000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2024-06-19',
                'berat'                     => 30,
                'jenis_id'                  => 3,
                'kategori_id'               => 7,
                'merek_id'                  => 36
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 30,  
                'kode'                      => 'B030',
                'nama'                      => "Nu Green Tea 450ml",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 3000, 
                'harga_jual'                => 7500, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 25,
                // 'tanggal_kadaluarsa'        => '2022-06-19',
                'berat'                     => 660,
                'jenis_id'                  => 2,
                'kategori_id'               => 4,
                'merek_id'                  => 2
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 31,  
                'kode'                      => 'B031',
                'nama'                      => "Teh Kotak Jasmine 200ml",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1200, 
                'harga_jual'                => 3000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 40,
                // 'tanggal_kadaluarsa'        => '2022-06-19',
                'berat'                     => 660,
                'jenis_id'                  => 2,
                'kategori_id'               => 4,
                'merek_id'                  => 49
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 32,  
                'kode'                      => 'B032',
                'nama'                      => "Golda Coffee Dolce Latte 200ml",
                'deskripsi'                 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget erat sed dui porttitor ultrices eu vehicula augue. Nunc quis vestibulum enim, a vulputate quam. Aliquam pharetra placerat lectus, ut semper tellus egestas nec. Vestibulum porttitor aliquam purus, et vulputate sapien vulputate ut. Sed pellentesque posuere erat, et sagittis urna efficitur sollicitudin. Pellentesque eget facilisis massa. Donec consequat libero eget malesuada pellentesque. Vestibulum molestie purus vitae blandit eleifend. Nunc fringilla massa ac justo feugiat rutrum. Phasellus id tincidunt libero. Praesent scelerisque, justo ut maximus porta, nibh nunc porta est, ut euismod sem mi ac lectus. Morbi in efficitur arcu. Maecenas laoreet ipsum non maximus volutpat.',
                // 'harga_beli'                => 1300, 
                'harga_jual'                => 3000, 
                'diskon_potongan_harga'     => 0,
                // 'jumlah_stok'               => 43,
                // 'tanggal_kadaluarsa'        => '2022-06-19',
                'berat'                     => 660,
                'jenis_id'                  => 2,
                'kategori_id'               => 5,
                'merek_id'                  => 3
            ]
        );
    }
}
