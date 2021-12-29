<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Transaksi</strong></h5>
    <div id="container-alamat">
        <div class="content-alamat">
            @if (count($penjualan) == 0)
                <h5 class="my-3">Maaf anda belum memiliki riwayat transaksi</h5>
            @else
                @for($i = 0; $i<count($penjualan); $i++) 
                    <div class="bg-light border border-4 p-3 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <p>Nomor Nota #<strong>{{ $penjualan[$i]->nomor_nota }}</strong></p>
                            </div>
                            <div class="col-6 text-right">
                                <p>{{ $penjualan[$i]->status }}</p>
                                {{-- {{ "Rp ".number_format($penjualan[$i]->total,0,',','.')  }} --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p>Tanggal {{ \Carbon\Carbon::parse($penjualan[$i]->tanggal)->isoFormat('D MMMM Y HH:mm') }} WIB</p>
                            </div>
                        </div>
                        <div class="row">
                                
                            @for($x=0; $x < count($detail_penjualan); $x++)
                                @if($penjualan[$i]->nomor_nota == $detail_penjualan[$x]->nomor_nota)
                                    <div class="col-6">
                                        {{ $detail_penjualan[$x]->nama }}
                                    </div>
                                    <div class="col-6">
                                        {{ " x".$detail_penjualan[$x]->kuantitas }}
                                    </div>
                                @endif
                            @endfor

                        </div>
                        <div class="float-right">
                            Total : {{ "Rp ".number_format($penjualan[$i]->total,0,',','.')  }}
                        </div>
                        <br>
                        <div class="row">
                            {{-- <a href="" class="btn btn-link text-success mx-auto">Lihat Detail</a> --}}
                            <button class="btn btn-link text-success mx-auto btnLihatDetailOrder"  data-dismiss="modal" data-toggle="modal" data-target="#modalDetailOrder" data-id="{{$penjualan[$i]->id}}">Lihat Detail</button>
                        </div>

                    </div>
                @endfor
            @endif

            <div class="d-flex justify-content-center">
                {{ $penjualan->render('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@include('pelanggan.user_menu.modal.detail_order')


@push('script_user_menu')

    {{-- <script src="{{ asset('/scripts/helper.js') }}"></script> --}}

    <script type="text/javascript">

        $(document).ready(function() {

            // console.log(moment());

            $('.btnLihatDetailOrder').on('click', function(event) {

                let id = event.target.getAttribute('data-id');

                // $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

                $.ajax({
                    type: 'GET',
                    url: '/order/show/'+id,   
                    success:function(data) {

                        // $('#modalLoading').modal('toggle');

                        $('#nomorNota').html("Nomor Nota #" + data.transaksi[0].nomor_nota);

                        let infoTransaksi = "";

                        let metodePembayaran = "";
                        if(data.transaksi[0].metode_pembayaran == "bank_transfer")
                        {
                            metodePembayaran = "Transfer Bank " + data.transaksi[0].bank.toUpperCase();
                        }
                        else 
                        {
                            metodePembayaran = "E-Wallet";
                        }

                        if(data.transaksi[0].status == "Pesanan sudah dibayar dan sedang disiapkan")
                        {
                            infoTransaksi =  `<div class="row">
                                                    <div class="col-4 ml-2">
                                                        Tanggal
                                                    </div>
                                                    <div class="col-7">
                                                        <p>`+ moment(data.transaksi[0].tanggal).tz('Asia/Jakarta').format("DD MMMM YYYY HH:mm:ss") +` WIB</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Metode Transaksi
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].metode_transaksi + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Status
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].status + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Waktu Lunas
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + moment(data.transaksi[0].waktu_lunas).tz('Asia/Jakarta').format("DD MMMM YYYY HH:mm:ss") + ` WIB</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Batasan Waktu Pengambilan
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + moment(data.transaksi[0].batasan_waktu_pengambilan).tz('Asia/Jakarta').format("DD MMMM YYYY")  + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Metode Pembayaran
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + metodePembayaran + `</p>
                                                    </div>
                                                </div>`;
                        }
                        else {
                            
                           infoTransaksi =  `<div class="row">
                                                <div class="col-4 ml-2">
                                                    Tanggal
                                                </div>
                                                <div class="col-5">
                                                    <p>`+ moment(data.transaksi[0].tanggal).tz('Asia/Jakarta').format("DD MMMM YYYY HH:mm:ss") +`</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 ml-2">
                                                    Metode Transaksi
                                                </div>
                                                <div class="col-5">
                                                    <p>` + data.transaksi[0].metode_transaksi + `</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 ml-2">
                                                    Status
                                                </div>
                                                <div class="col-5">
                                                    <p>` + data.transaksi[0].status + `</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 ml-2">
                                                    Metode Pembayaran
                                                </div>
                                                <div class="col-5">
                                                    <p>` + metodePembayaran + `</p>
                                                </div>
                                            </div>`;
                        }

                        $('.infoTransaksi').html(infoTransaksi);

                        let rowBarang = "";
                        let rowInfoPengiriman = "";

                        if(data.transaksi[0].metode_transaksi == "Ambil di toko")
                        {
                            for(let i=0; i < data.barang.length; i++)
                            {
                                rowBarang += `<div class="row">
                                                    <div class="col-4 ml-2">
                                                            <img src="` + 'http://localhost:8000' + data.barang[i].foto + `" alt="Foto Barang">
                                                    </div>
                                                    <div class="col-7">
                                                            <p>`+ data.barang[i].nama + `</p>
                                                            <div class="row">
                                                                <div class="col-6"><p>  x`+ data.barang[i].kuantitas + `</p></div>
                                                                <div class="col-6"><p class="text-right">` + convertAngkaToRupiah(data.barang[i].subtotal) + `</p></div>
                                                            </div>
                                                    </div>
                                                </div>`;

                            }

                            $('#labelTotalTarifOngkir').html("");

                            $('.rowInfoAlamatPengiriman').html("");

                            $('.rowInfoPengiriman').html("");

                            $('#totalTarifOngkir').html("");

                        }
                        else // dikirim ke alamat
                        {   
                            $('.rowInfoAlamatPengiriman').html(`<h5>Alamat Pengiriman</h5>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    ` + data.barang[0].alamat + `
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    ` + data.barang[0].kecamatan + `, ` + data.barang[0].kota_kabupaten + `, ` + data.barang[0].kode_pos + `
                                                                </div>
                                                            </div>`);

                            let estimasiTiba = null;
                            
                            if(data.barang[0].nama_shipper == 'Gojek' ||data.barang[0].nama_shipper == 'Grab')
                            {
                                estimasiTiba = moment(data.barang[0].estimasi_tiba).format("DD MMMM YYYY HH:mm:ss") + " WIB";
                            }
                            else 
                            {
                                estimasiTiba = moment(data.barang[0].estimasi_tiba).format("DD MMMM YYYY");
                            }

                            $('.rowInfoPengiriman').html(`<h5>Pengiriman</h5>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    ` + data.barang[0].jenis_pengiriman + ` ` + data.barang[0].nama_shipper + `
                                                                </div>
                                                                <div class="col-12">
                                                                    Estimasi pengiriman tiba ` + estimasiTiba + `
                                                                </div>
                                                            </div>
                                                            <hr>`);                                
                            
                            for(let i=0; i < data.barang.length; i++)
                            {
                                rowBarang += `<div class="row">
                                                    <div class="col-4 ml-2">
                                                            <img src="` + 'http://localhost:8000' + data.barang[i].foto + `" alt="Foto Barang">
                                                    </div>
                                                    <div class="col-7">
                                                            <p>`+ data.barang[i].nama + `</p>
                                                            <div class="row">
                                                                <div class="col-6"><p>  x`+ data.barang[i].kuantitas + `</p></div>
                                                                <div class="col-6"><p class="text-right">` + convertAngkaToRupiah(data.barang[i].subtotal) + `</p></div>
                                                            </div>
                                                    </div>
                                                </div>`;

                            }

                            $('#labelSubtotalProduk').html("Subtotal Produk :");

                            $('#subtotalProduk').html(convertAngkaToRupiah(data.transaksi[0].total-data.barang[0].tarif));

                            $('#labelTotalTarifOngkir').html("Total Tarif Ongkir :");

                            $('#totalTarifOngkir').html(convertAngkaToRupiah(data.barang[0].tarif));

                        }

                        $('.rowBarang').html(rowBarang);

                        $('#labelTotal').html("Total :");

                        $('#totalTransaksi').html(convertAngkaToRupiah(data.transaksi[0].total));
                        

                    }   
                });
            })

        });

    </script>
@endpush




