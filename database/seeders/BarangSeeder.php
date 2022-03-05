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
                'kode'                      => 'B0081',
                'nama'                      => 'Golda Coffee Dolce Latte 200Ml',
                'deskripsi'                 => '<p>Diracik dari biji kopi berstandar tertinggi (gold),&nbsp;<strong>GOLDA</strong>&nbsp;Coffee memberikan sensasi tekstur yang lembut, rendah asam, disertai aroma kacang, dan mengandung rasa manis coklat atau karamel.</p>

                <p><strong>CARA PENGGUNAAN :</strong><br />
                Sajikan dingin lebih nikmat<br />
                &nbsp;</p>
                
                <p><strong>CARA PENYIMPANAN :</strong><br />
                Setelah dibuka simpan dalam lemari es dan habiskan dalam waktu 24 jam<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Air, gula, ekstrak kopi, susu skim bubuk, krimer nabati, penstabil nabati, perisa sintetik kopi, pengemulsi nabati.<br />
                &nbsp;</p>
                
                <p><strong>OTHER DETAILS :</strong><br />
                Kopi dengan aroma yang khas dan nikmat terpadu susu yang lembut.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan: 1<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 140kkal, energi dari lemak 20kkal, lemak total 2g, protein 2g, karbohidrat total 27g, gula 17g, natrium 100mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji: 200ml</p>',
                'harga_jual'                => 3700, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 200,
                'jenis_id'                  => 2,
                'kategori_id'               => 5,
                'merek_id'                  => 2,
                'supplier_id'               => 2,
                'foto'                      => '/images/barang/B0081/B0081.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 2,  
                'kode'                      => 'B0082',
                'nama'                      => 'YOU C-1000 Orange Water 500Ml',
                'deskripsi'                 => '&lt;p&gt;&lt;strong&gt;Deskripsi&lt;/strong&gt;&lt;/p&gt;

                &lt;p&gt;YOU-C 1000 ORANGE merupakan minuman rasa jeruk. Kandungan Vitamin C 1000 mg yang terdapat didalamnya membantu memelihara daya tahan tubuh.&lt;/p&gt;
                
                &lt;p&gt;&lt;strong&gt;Komposisi&lt;/strong&gt;&lt;/p&gt;
                
                &lt;p&gt;Gula, Fruktosa, Sari Buah Kurang Dari 10% Yang Berasal dari Jus Buah Orange Segar, Vitamin (C, B1, E [Dari Kedelai], Niacin), Lemon Flavour, Pengatur Keasaman, Pewarna Kuning Benibana (Safflower) dan Air sampai dengan 140 ml.&lt;/p&gt;',
                'harga_jual'                => 8200, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 500,
                'jenis_id'                  => 2,
                'kategori_id'               => 7,
                'merek_id'                  => 3,
                'supplier_id'               => 2,
                'foto'                      => '/images/barang/B0082/B0082.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 3,  
                'kode'                      => 'B0083',
                'nama'                      => 'Good Day Funtastic Mocacinno Coffee 250Ml',
                'deskripsi'                 => '<p>Minuman kopi dalam kemasan botol dengan perpaduan rasa dan aroma kopi yang lembut dan istimewa.</p>

                <p><strong>CARA PENGGUNAAN :</strong><br />
                Kocok sebelum diminum. Dingin lebih nikmat<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Air, gula, krimer nabati, kopi, instant (1%), susu skim bubuk, bubuk kakao, penstabil makanan, perisa identik alami moka.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan : 1<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 140kkal, energi dari lemak 30kkal. % AKG: Lemak total 2,3g, lemak jenuh 3g, lemak trans 0g, kolesterol 10mg, protein 3g, karbohidrat total 26g, gula 10g, natrium 25mg, kalium 60mg. Vitamin A 0%, vitamin C 0%, kalsium 2%, zat besi 4%.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji : 250mL</p>',
                'harga_jual'                => 6600, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 250,
                'jenis_id'                  => 2,
                'kategori_id'               => 5,
                'merek_id'                  => 4,
                'supplier_id'               => 2,
                'foto'                      => '/images/barang/B0083/B0083.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 4,  
                'kode'                      => 'B0084',
                'nama'                      => 'Pocari Sweat 350Ml',
                'deskripsi'                 => '<p>Pocari sweat adalah minuman isotonik yang dapat diserap tubuh karena osmolaritasnya yang baik dan terdiri dari elekrolit-elektrolit.<br />
                &nbsp;</p>
                
                <p><strong>CARA PENYIMPANAN :</strong><br />
                Jangan di simpan dalam freezer. Hindari sinar matahari langsung dan temperatur tinggi.<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Air, gula, pengatur keasaman, perisa sitrus, natrium klorida, kalium klorida, kalsium laktat, magnesium karbonat dan antioksidan asam askorbat.<br />
                &nbsp;</p>
                
                <p><strong>OTHER DETAILS :</strong><br />
                Pocari sweat adalah minuman isotonik yang dapat diserap tubuh karena osmolaritasnya yang baik dan terdiri dari elekrolit-elektrolit.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan : 3.5<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 25kkal. % AKG: lemak total 0g, protein 0g, karbohidrat total 6g, natrium 45mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji : 100mL</p>',
                'harga_jual'                => 6500, 
                'diskon_potongan_harga'     => 300,
                'periode_diskon_id'         => 1,
                'berat'                     => 350,
                'jenis_id'                  => 2,
                'kategori_id'               => 7,
                'merek_id'                  => 5,
                'supplier_id'               => 2,
                'foto'                      => '/images/barang/B0084/B0084.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 5,  
                'kode'                      => 'B0085',
                'nama'                      => 'Teh Pucuk Harum Teh Melati 350 Ml',
                'deskripsi'                 => '<p>Teh pucuk harum minuman teh beraroma melati dibuat dengan pucuk daun teh pilihan dengan ekstrak melati yang menyegarkan.<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Air, gula, teh melati (daun teh + bunga melati ), perisa bunga melati.<br />
                &nbsp;</p>
                
                <p><strong>OTHER DETAILS :</strong><br />
                Teh pucuk harum minuman teh beraroma melati dibuat dengan pucuk daun teh pilihan dengan ekstrak melati yang menyegarkan.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan : 1<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi 150kkal, energi dari lemak 0g. % AKG: Lemak total 0g, protein 0g, karbohidrat total 39g, gula 20g, natrium 20mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji : 350mL</p>',
                'harga_jual'                => 3700, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 350,
                'jenis_id'                  => 2,
                'kategori_id'               => 4,
                'merek_id'                  => 6,
                'supplier_id'               => 2,
                'foto'                      => '/images/barang/B0085/B0085.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 6,  
                'kode'                      => 'B0086',
                'nama'                      => 'Gangsar Kacang Atom 140G',
                'deskripsi'                 => '<p>Kacang atom Gangsar cocok untuk pendamping menu bakso, mie ayam ataupun pengganti krupuk</p>',
                'harga_jual'                => 7500, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 140,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 7,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0086/B0086.jpg'
            ]
        );  

        DB::table('barang')->insert(
            [   
                'id'                        => 7,  
                'kode'                      => 'B0087',
                'nama'                      => 'Japota Potato Chips Ayam Bawang 68G',
                'deskripsi'                 => '<p>Japota Ayam Bawang, dibuat dengan kentang asli dan diolah menggunakan thin-cut technology, chipsnya tipis dengan taburan bits bawang goreng aslinya memberikan sensasi rasa yang lebih enak dan bikin gak cukup satu!</p>',
                'harga_jual'                => 10300, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 68,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 8,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0087/B0087.jpg'
            ]
        );


        DB::table('barang')->insert(
            [   
                'id'                        => 8,  
                'kode'                      => 'B0088',
                'nama'                      => 'Japota Potato Chips Madu Mentega 68G',
                'deskripsi'                 => '<p>Makanan ringan yang terbuat dari kentang pilihan dengan rasa madu mentega yang enak.<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Kentang, minyak kelapa sawit, bumbu rasa madu mentega.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan: 2.5<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 130, energi dari lemak 50kkal. % AKG: Lemak total 5g, protein 1g, karbohidrat total 20g, serat pangan 2g, gula total 1g, natrium 75mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji: 28g</p>',
                'harga_jual'                => 10300, 
                'diskon_potongan_harga'     => 200,
                'periode_diskon_id'         => 1,
                'berat'                     => 68,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 8,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0088/B0088.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 9,  
                'kode'                      => 'B0089',
                'nama'                      => 'Potabee Snack Potato Chips Bbq 68G',
                'deskripsi'                 => "<p>Potabee terbuat dari kentang asli dan diolah menggunakan V-Cut Technology yang bikinkriuknya pecah dan dapat mengunci rasa lebih banyak . Potabee Beef BBQ dilengkapi dengan taburan bits BBQ asli yang bikin ketagihan. Potabee Grilled Seaweed dilengkapi dengan taburan bits rumput laut asli yang bikin ketagihan.<br />
                <br />
                <strong>KOMPOSISI :</strong><br />
                Kentang ( 55%) Minyak kelapa sawit ( mengandung antioksidan Butil Hidrokinon Tersier(TBHQ)). Bumbu rasa daging panggang (mengandung Gulaperisa sintetik dan alami(mengandung penguat rasa(Mononatrium GlutamatDinatrium Inosinat&amp;guanilat). Antioksidan(Alfa TokoferolAsam Askorbat dab BHA) Lemak sapi (0.002%)GaramPenguat rasa( Mononatrium glutamatdinatrium Inosinat &amp; Guanilat)Rempah susu bubukbubuk kecapbubuk kejububuk ikan) Mengandung Alegren lihat daftar bahan yang dicetak tebal.</p>",
                'harga_jual'                => 9700, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 68,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 9,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0089/B0089.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 10,  
                'kode'                      => 'B0090',
                'nama'                      => 'Soyjoy Fruit Soy Bar Raisin Almond 30G',
                'deskripsi'                 => '<p>Kedelai mengandung nutrisi penting seperti protein, serat, vitamin dan mineral. SOY JOY dibuat dengan tepung kedelai dipadu dengan buah-buahan yang dikeringkan, untuk menemani aktivitas sehari-hari.<br />
                &nbsp;</p>
                
                <p><strong>CARA PENYIMPANAN :</strong><br />
                Untuk menjaga kualitas &amp; kesegaran, simpan ditempat sejuk dan kering.<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Tepung kedelai, kismis (23%), buah pepaya kering, buah nanas kering, mentega, telur, kacang tanah (9%), coklat, gula, perisa, garam.<br />
                &nbsp;</p>
                
                <p><strong>OTHER DETAILS :</strong><br />
                Mengandung ISOFLAVON 18mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan: 1<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 140kkal, energi dari lemak 60kkal. % AKG: Lemak total 7g, protein 7g, karbohidrat total 13g, serat pangan 3g, gula 9g, natrium 50mg, kalium 260mg. Vitamin A 4%, Vitamin B1 8%, vitamin B2 8%, vitamin B6 8%, vitamin E 10%, kalsium 4%, besi 6%, asam folat 20%.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji: 30g</p>',
                'harga_jual'                => 9400, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 30,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 10,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0090/B0090.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 11,  
                'kode'                      => 'B0091',
                'nama'                      => 'Nabati Siip Keju 50G',
                'deskripsi'                 => '<p>Makanan ringan berbahan dasar jagung berbentuk bite size, dipadukan dengan bumbu berlimpah sehingga menghasilkan produk yang nikmat dengan harga terjangkau. SIIP emang bikin nagih!<br />
                <br />
                <br />
                <strong>KOMPOSISI :</strong><br />
                Jagung, Minyak Nabati (mengandung Antioksidan TBHQ), Gula, Dekstrosa, Maltodekstrin, Whey bubuk, Keju Bubuk, Tepung terigu, Keju Bubuk (mengandung pewarna kurkumin CI 75300 dan kuning FCF CI 15985, antioksidan Tokoferol dan askrobil palmitat), Pati jagung, Penguat rasa mononatrium glutamat, garam, pengembang natrium</p>',
                'harga_jual'                => 4600, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 50,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 11,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0091/B0091.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 12,  
                'kode'                      => 'B0092',
                'nama'                      => 'Nasi Ayam & Mie 450G',
                'deskripsi'                 => '<p>Yuk dimakan pasti bikin nagih dan kenyang loooh...</p>',
                'harga_jual'                => 14000, 
                'diskon_potongan_harga'     => 0,
                'barang_konsinyasi'         => 1,
                'berat'                     => 450,
                'jenis_id'                  => 1,
                'kategori_id'               => 1,
                'merek_id'                  => 1,
                'supplier_id'               => 3,
                'foto'                      => '/images/barang/B0092/B0092.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 13,  
                'kode'                      => 'B0093',
                'nama'                      => 'Chiki Stick Keju 150G',
                'deskripsi'                 => '<p>Chiki stik keju,makanan ringan yang sangat digemari banyak orang Kaya akan rasa kejunya dan cocok untuk menemani kalian bersantai dan traveling bersama keluarga</p>',
                'harga_jual'                => 12000, 
                'diskon_potongan_harga'     => 0,
                'barang_konsinyasi'         => 1,
                'berat'                     => 150,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 1,
                'supplier_id'               => 4,
                'foto'                      => '/images/barang/B0093/B0093.jpg'
            ]
        );

        DB::table('barang')->insert(
            [   
                'id'                        => 14,  
                'kode'                      => 'B0094',
                'nama'                      => 'Potabee Potato Chips Wagyu Beef Steak 68G',
                'deskripsi'                 => '<p>POTABEE WAGYU BEEF PERPADUAN KENTANG ASLI YANG DIPOTONG DENGAN V-CUT TECHNOLOGY BERTABUR BITS WAGYU ASLI YANG GURIH. AROMA DAN RASA WAGYU YANG TASTY DIJAMIN BIKIN KAMU KETAGIHAN SAMA POTABEE WAGYU BEEF STEAK<br />
                <br />
                <br />
                <strong>KOMPOSISI :</strong><br />
                KENTANG (54%), MINYAK KELAPA SAWIT, BUMBU RASA STEAK DAGING SAPI WAGYU, GARAM, PERISA SINTETIK DAN PERISA ALAMI, EKSTRAK DAGING SAPI (0.12%) BUBUK KEJU, KRIMER NABATI, PEWARNA SINTETIK MAKANAN.</p>',
                'harga_jual'                => 9700, 
                'diskon_potongan_harga'     => 200,
                'periode_diskon_id'         => 1,
                'barang_konsinyasi'         => 1,
                'berat'                     => 68,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 9,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0094/B0094.jpg'
            ]
        );


        DB::table('barang')->insert(
            [   
                'id'                        => 15,  
                'kode'                      => 'B0095',
                'nama'                      => 'Japota Potato Chips Umami Japanese Seaweed 68G',
                'deskripsi'                 => '<p>Makanan ringan yang terbuat dari kentang pilihan dengan rasa rumput laut yang enak.<br />
                &nbsp;</p>
                
                <p><strong>KOMPOSISI :</strong><br />
                Kentang, minyak kelapa sawit, bumbu rasa rumput laut, garam, penguat rasa mononatrium glutamat, dinatrium inosinat dan dinatrium guanilat, rumput laut, susu bubuk, bubuk ikan.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER KEMASAN :</strong><br />
                Sajian per kemasan: 2.5<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN PER SERVING :</strong><br />
                Energi total 150, energi dari lemak 90kkal. % AKG: Lemak total 1g, protein 1g, karbohidrat total 15g, serat pangan 2g, gula total 1g, natrium 150mg.<br />
                &nbsp;</p>
                
                <p><strong>TAKARAN SAJI :</strong><br />
                Takaran saji: 28g</p>',
                'harga_jual'                => 10300, 
                'diskon_potongan_harga'     => 0,
                'berat'                     => 68,
                'jenis_id'                  => 1,
                'kategori_id'               => 2,
                'merek_id'                  => 8,
                'supplier_id'               => 1,
                'foto'                      => '/images/barang/B0095/B0095.jpg'
            ]
        );
    }

}
