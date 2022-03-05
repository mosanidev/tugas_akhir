<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Transaksi</strong></h5>
    <div id="container-alamat">
        <div class="content-alamat">

            @if (count($penjualan) == 0)
                <h5 class="my-3">Anda belum memiliki riwayat transaksi</h5>
            @else
                @for($i = 0; $i<count($penjualan); $i++) 
                    <div class="bg-light border border-4 p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <p>Nomor Nota #<strong>{{ $penjualan[$i]->nomor_nota }}</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p>Metode Transaksi</p>
                            </div>
                            <div class="col-8">
                                <p>{{ $penjualan[$i]->metode_transaksi }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <p>Status</p>
                            </div>
                            <div class="col-8">
                                <p><span class="badge badge-secondary">{{ $penjualan[$i]->status_jual }}</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                Tanggal 
                            </div>
                            <div class="col-8">
                                <p>{{ \Carbon\Carbon::parse($penjualan[$i]->tanggal)->isoFormat('D MMMM Y HH:mm') }} WIB</p>
                            </div>
                        </div>
                        <p>Barang dibeli :</p> 
                        <hr>
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
                        <hr> 
                        <div class="row">
                            <div class="col-10">
                                <p class="text-right">
                                    Total : 
                                </p>
                            </div>
                            <div class="col-2">
                                <p class="text-right">
                                    {{ "Rp ".number_format($penjualan[$i]->total,0,',','.')  }}
                                </p>
                            </div>
                        </div>
                        <button class="btn btn-block btn-link text-success mx-auto border border-black btnLihatDetailOrder" data-dismiss="modal" data-toggle="modal" data-target="#modalDetailOrder" data-id="{{$penjualan[$i]->id }}"><strong>Lihat Detail</strong></button>
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
@include('pelanggan.user_menu.modal.cek_resi')


@push('script_user_menu')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $(document).on('click', '.btnLihatInfoPengiriman', function(e) {

                const pengiriman_id = $(this).attr('data-id');
                //do whatever
                console.log(pengiriman_id);

                $.ajax({
                    type: 'GET',
                    url: '/pengiriman/lacak_resi/'+pengiriman_id,
                    beforeSend: function() {

                        $('#modalDetailOrder').modal('toggle');
                        
                        $('#modalCekResi').modal('toggle');

                        $('#modalCekResi .modal-body .isiInfoKirim').html(`<div class="m-5" id="loader">
                                                                                <div class="text-center">
                                                                                    <div class="spinner-border" style="width: 5rem; height: 5rem; color:grey;" role="status">
                                                                                        <span class="sr-only">Loading...</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>`);

                    },
                    success: function(data){

                        $('#modalCekResi .modal-body .isiInfoKirim').html(`<div class="infoKirim">

                                                                            </div>

                                                                            <div class="lacakResi">
                                                                            </div>`);

                        let estimasiTiba = null;

                        if(data.pengiriman[0].nama_shipper == 'Gojek' || data.pengiriman[0].nama_shipper == 'Grab')
                        {
                            estimasiTiba = moment(data.pengiriman[0].estimasi_tiba).format("DD MMMM YYYY HH:mm") + " WIB";
                        }
                        else 
                        {
                            estimasiTiba = moment(data.pengiriman[0].estimasi_tiba).format("DD MMMM YYYY");
                        }

                        $('.infoKirim').html(`<h5>Pengiriman</h5>
                                                <div class="row">
                                                    <div class="col-12">
                                                        ` + data.pengiriman[0].jenis_pengiriman + ` ` + data.pengiriman[0].nama_shipper + `
                                                    </div>
                                                    <div class="col-12">
                                                        Estimasi pengiriman tiba ` + estimasiTiba + `
                                                    </div>
                                                    <div class="col-12">
                                                        Ongkos kirim ` + convertAngkaToRupiah(data.pengiriman[0].tarif) + `
                                                    </div>
                                                </div>
                                                <hr>`);

                        let rowKirim = `<div class="row">
                                            <div class="col-3">
                                                Nomor Resi
                                            </div>
                                            <div class="col-9">
                                                ` + data.pengiriman[0].nomor_resi + `
                                            </div>
                                        </div>
                                        <br>`;

                        if(data.riwayat_pengiriman != null)
                        {
                            for(let o = 0; o < data.riwayat_pengiriman.history.length; o++)
                            {
                                // <i class="fa-solid fa-circle d-inline"></i>
                                rowKirim += `<div class="row">
                                                <div class="col-3">
                                                    <p class="mt-2">` + moment(data.riwayat_pengiriman.history[o].updated_at).format("DD MMMM YYYY HH:mm") + ` WIB</p><br>
                                                </div>
                                                <div class="col-9">` +
                                                    `<p class="mt-2">` +  data.riwayat_pengiriman.history[o].note + `</p><br> ` +
                                                    `</div>
                                            </div>`;
                                // data.riwayat_pengiriman.history[o].status
                            }

                            $('.lacakResi').append(rowKirim);
                        }

                    }
                })

            });
            // $('.infoPengiriman').on('click', '.btnLihatInfoPengiriman', function() {
                
            //     console.log("tesss");
            // });

            $('.btnLihatDetailOrder').on('click', function(event) {

                let estimasiTiba = null;

                let id = $(this).attr('data-id');

                let index = null;

                $.ajax({
                    type: 'GET',
                    url: '/order/show/'+id, 
                    beforeSend: function() {
                        
                        $('.rowAlamatPengiriman').html("");
                        $('.rowContentBrg').html("");
                        $('.rowPengiriman').html("");
                        $('.infoTransaksi').html("");
                        $('#labelTotalTarifOngkir').html("");                        
                        $('#totalTarifOngkir').html("");
                        $('#labelSubtotalProduk').html("");
                        $('#subtotalProduk').html("");
                        $('#totalTransaksi').html("");
                        $('#labelTotal').html("");

                        showLoader($('#modalDetailOrder .modal-body'), $('.infoTransaksi'));

                    },
                    success:function(data) {

                        // console.log(data);

                        closeLoader($('#modalDetailOrder .modal-body'), $('.infoTransaksi'));

                        $('#nomorNota').html("Nomor Nota #" + data.transaksi[0].nomor_nota);

                        let infoTransaksi = "";

                        let metodePembayaran = "";
                        if(data.transaksi[0].metode_pembayaran == "bank_transfer")
                        {
                            metodePembayaran = "Transfer Bank " + data.transaksi[0].bank.toUpperCase();
                        }
                        else 
                        {
                            metodePembayaran = data.transaksi[0].metode_pembayaran;
                        }

                        if(data.transaksi[0].status_jual == "Pesanan sudah dibayar")
                        {
                            if(data.transaksi[0].metode_transaksi == "Ambil di toko")
                            {
                                infoTransaksi =  `<div class="row">
                                                    <div class="col-4 ml-2">
                                                        Tanggal
                                                    </div>
                                                    <div class="col-7">
                                                        <p>`+ moment(data.transaksi[0].tanggal).format("DD MMMM YYYY HH:mm") +` WIB</p>
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
                                                        Alamat Pengambilan
                                                    </div>
                                                    <div class="col-7">
                                                        <p>Minimarket KopKar
                                                        <br>

                                                        Jl. Raya Rungkut, Kec. Rungkut, Kota Surabaya, Jawa Timur 60293

                                                        <br>
                                                        Buka Hari Senin-Sabtu
                                                        jam 08:00 - 16:00</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Status
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].status_jual + `</p>\n
                                                        <p>Harap ambil pesanan anda di toko</p>\n
                                                        <p>Jika pesanan belum diambil hingga ` + moment(data.transaksi[0].tanggal).add(3, 'days').format("DD MMMM YYYY") + ` ` + moment(data.transaksi[0].tanggal).add(3, 'days').format("HH:mm") + ` WIB, maka bukan tanggung jawab dari toko</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Status Bayar
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].status_bayar + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Waktu Lunas
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + moment(data.transaksi[0].waktu_lunas).format("DD MMMM YYYY HH:mm") + ` WIB</p>
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

                                                if(data.transaksi[0].nomor_rekening != null)
                                                {
                                                    infoTransaksi += `<div class="row">
                                                        <div class="col-4 ml-2">
                                                                Nomor Rekening Tujuan
                                                            </div>
                                                            <div class="col-5">
                                                                <p>` + data.transaksi[0].nomor_rekening + `</p>
                                                            </div>
                                                        </div>
                                                    </div>`;
                                                }
                            }
                            else 
                            {
                                infoTransaksi =  `<div class="row">
                                                    <div class="col-4 ml-2">
                                                        Tanggal
                                                    </div>
                                                    <div class="col-7">
                                                        <p>`+ moment(data.transaksi[0].tanggal).format("DD MMMM YYYY HH:mm") +` WIB</p>
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
                                                        <p>` + data.transaksi[0].status_jual + `</p>\n
                                                        <p>Harap menunggu pesanan untuk dikirimkan</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Status Bayar
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].status_bayar + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Waktu Lunas
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + moment(data.transaksi[0].waktu_lunas).format("DD MMMM YYYY HH:mm") + ` WIB</p>
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

                                                if(data.transaksi[0].nomor_rekening != null)
                                                {
                                                    infoTransaksi += `<div class="row">
                                                        <div class="col-4 ml-2">
                                                                Nomor Rekening Tujuan
                                                            </div>
                                                            <div class="col-5">
                                                                <p>` + data.transaksi[0].nomor_rekening + `</p>
                                                            </div>
                                                        </div>
                                                    </div>`;
                                                }
                            }
                                                
                        }
                        else {
                            
                            if(data.transaksi[0].metode_transaksi == "Ambil di toko")
                            {
                                infoTransaksi =  `<div class="row">
                                                        <div class="col-4 ml-2">
                                                            Tanggal
                                                        </div>
                                                        <div class="col-5">
                                                            <p>`+ moment(data.transaksi[0].tanggal).format("DD MMMM YYYY") + ` `+ moment(data.transaksi[0].tanggal).format("HH:mm") +` WIB </p>
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
                                                            Alamat Pengambilan
                                                        </div>
                                                        <div class="col-7">
                                                            <p>Minimarket KopKar
                                                            <br>

                                                            Jl. Raya Rungkut, Kec. Rungkut, Kota Surabaya, Jawa Timur 60293

                                                            <br>
                                                            Buka Hari Senin-Sabtu
                                                            jam 08:00 - 16:00</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 ml-2">
                                                            Status
                                                        </div>
                                                        <div class="col-5">
                                                            <p>` + data.transaksi[0].status_jual + `</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4 ml-2">
                                                            Status Bayar
                                                        </div>
                                                        <div class="col-7">
                                                            <p>` + data.transaksi[0].status_bayar + `</p>
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

                                                    if(data.transaksi[0].nomor_rekening != null)
                                                    {
                                                        infoTransaksi += `<div class="row">
                                                            <div class="col-4 ml-2">
                                                                    Nomor Rekening Tujuan
                                                                </div>
                                                                <div class="col-5">
                                                                    <p>` + data.transaksi[0].nomor_rekening + `</p>
                                                                </div>
                                                            </div>
                                                        </div>`;
                                                    }

                                                    infoTransaksi += `<div class="row">
                                                                        <div class="col-4 ml-2">
                                                                            Batasan Waktu Pembayaran
                                                                        </div>
                                                                        <div class="col-5">
                                                                            <p>` + moment(data.transaksi[0].batasan_waktu).format("DD MMMM YYYY") + ` `+ moment(data.transaksi[0].batasan_waktu).format("HH:mm") +` WIB </p>
                                                                        </div>
                                                                    </div>`;
                            }
                            else 
                            {
                                infoTransaksi =  `<div class="row">
                                                    <div class="col-4 ml-2">
                                                        Tanggal
                                                    </div>
                                                    <div class="col-5">
                                                        <p>`+ moment(data.transaksi[0].tanggal).format("DD MMMM YYYY") + ` `+ moment(data.transaksi[0].tanggal).format("HH:mm") +` WIB </p>
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
                                                        <p>` + data.transaksi[0].status_jual + `</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 ml-2">
                                                        Status Bayar
                                                    </div>
                                                    <div class="col-7">
                                                        <p>` + data.transaksi[0].status_bayar + `</p>
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

                                                if(data.transaksi[0].nomor_rekening != null)
                                                {
                                                    infoTransaksi += `<div class="row">
                                                        <div class="col-4 ml-2">
                                                                Nomor Rekening Tujuan
                                                            </div>
                                                            <div class="col-5">
                                                                <p>` + data.transaksi[0].nomor_rekening + `</p>
                                                            </div>
                                                        </div>
                                                    </div>`;
                                                }

                                                infoTransaksi += `<div class="row">
                                                                    <div class="col-4 ml-2">
                                                                        Batasan Waktu Pembayaran
                                                                    </div>
                                                                    <div class="col-5">
                                                                        <p>` + moment(data.transaksi[0].batasan_waktu).format("DD MMMM YYYY") + ` `+ moment(data.transaksi[0].batasan_waktu).format("HH:mm") +` WIB </p>
                                                                    </div>
                                                                </div>`;
                            }
                        }

                        $('.infoTransaksi').html(infoTransaksi);

                        if(data.transaksi[0].metode_transaksi == "Ambil di toko")
                        {
                            // tampilkan data barang
                            for(let i=0; i < data.barang.length; i++)
                            {
                                $('.rowContentBrg').append(`<div class="row">
                                                            <div class="col-4 ml-2">
                                                                    <img src="` + 'http://localhost:8000' + data.barang[i].foto + `" height="150" style="object-fit: cover;" alt="Foto Barang">
                                                            </div>
                                                            <div class="col-7">
                                                                    <p>`+ data.barang[i].nama + `</p>
                                                                    <div class="row">
                                                                        <div class="col-6"><p>  x`+ data.barang[i].kuantitas + `</p></div>
                                                                        <div class="col-6"><p class="text-right">` + convertAngkaToRupiah(data.barang[i].subtotal) + `</p></div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <hr>`);

                            }

                            $('#labelTotalTarifOngkir').html("");

                            $('#totalTarifOngkir').html("");

                        }
                        else if(data.transaksi[0].metode_transaksi == "Dikirim ke alamat") // dikirim ke alamat
                        {   
                            $('.rowAlamatPengiriman').append(`<h5>Alamat Pengiriman</h5>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[0].alamat + `
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[0].kecamatan + `, ` + data.pengiriman[0].kota_kabupaten + `, ` + data.pengiriman[0].kode_pos + `
                                                            </div>
                                                        </div>`);

                            if(data.pengiriman[0].nama_shipper == 'Gojek' || data.pengiriman[0].nama_shipper == 'Grab')
                            {
                                estimasiTiba = moment(data.pengiriman[0].estimasi_tiba).format("DD MMMM YYYY HH:mm") + " WIB";
                            }
                            else 
                            {
                                estimasiTiba = moment(data.pengiriman[0].estimasi_tiba).format("DD MMMM YYYY");
                            }

                            for(let i=0; i < data.barang.length; i++)
                            {
                                $('.rowContentBrg').append(`<div class="row my-2">
                                                            <div class="col-4 ml-2">
                                                                    <img src="` + 'http://localhost:8000' + data.barang[i].foto + `" height="150" style="object-fit: cover;" alt="Foto Barang">
                                                            </div>
                                                            <div class="col-7">
                                                                    <p>`+ data.barang[i].nama + `</p>
                                                                    <div class="row">
                                                                        <div class="col-6"><p>  x`+ data.barang[i].kuantitas + `</p></div>
                                                                        <div class="col-6"><p class="text-right">` + convertAngkaToRupiah(data.barang[i].subtotal) + `</p></div>
                                                                    </div>
                                                            </div>
                                                        </div>`);

                            }

                            $('.rowPengiriman').append(`<h5>Pengiriman</h5>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[0].jenis_pengiriman + ` ` + data.pengiriman[0].nama_shipper + `
                                                            </div>
                                                            <div class="col-12">
                                                                Estimasi pengiriman tiba ` + estimasiTiba + `
                                                            </div>
                                                            <div class="col-12">
                                                                Ongkos kirim ` + convertAngkaToRupiah(data.pengiriman[0].tarif) + `
                                                            </div>
                                                            <button class="btn btn-link text-success btnLihatInfoPengiriman" data-id="` + data.pengiriman[0].pengiriman_id + `"><strong>Lihat informasi pengiriman</strong></button>
                                                        </div>
                                                        <hr>`);              

                            $('#labelSubtotalProduk').html("Subtotal Produk :");

                            $('#subtotalProduk').html(convertAngkaToRupiah(data.transaksi[0].total-data.barang[0].tarif));

                            $('#labelTotalTarifOngkir').html("Total Tarif Ongkir :");

                            $('#totalTarifOngkir').html(convertAngkaToRupiah(data.barang[0].tarif));

                        }
                        else if (data.transaksi[0].metode_transaksi == "Dikirim ke berbagai alamat") // dikirim ke berbagai alamat
                        {
                            let subTotalProduk = 0;

                            let totalTarif = 0;

                            let infoDetailBrg = "";

                            for(let i=0; i < data.pengiriman.length; i++)
                            {
                                if(data.pengiriman[i].nama_shipper == 'Gojek' ||data.pengiriman[i].nama_shipper == 'Grab')
                                {
                                    estimasiTiba = moment(data.pengiriman[i].estimasi_tiba).format("DD MMMM YYYY HH:mm") + " WIB";
                                }
                                else 
                                {
                                    estimasiTiba = moment(data.pengiriman[i].estimasi_tiba).format("DD MMMM YYYY");
                                }

                                totalTarif += data.pengiriman[i].tarif;

                                infoDetailBrg += `<h5>Alamat Pengiriman</h5>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[i].alamat + `
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[i].kecamatan + `, ` + data.pengiriman[i].kota_kabupaten + `, ` + data.pengiriman[i].provinsi + `, ` + data.pengiriman[i].kode_pos + `
                                                            </div>
                                                        </div>`;


                                for(let y=0; y < data.barang.length; y++)
                                {
                                    if(data.barang[y].alamat_pengiriman_id == data.pengiriman[i].id)
                                    {
                                        infoDetailBrg +=`<div class="row mt-2">
                                                        <div class="col-4 ml-2">
                                                                <img src="` + 'http://localhost:8000' + data.barang[y].foto + `" height="150" style="object-fit: cover;" alt="Foto Barang">
                                                        </div>
                                                        <div class="col-7">
                                                                <p>`+ data.barang[y].nama + `</p>
                                                                <div class="row">
                                                                    <div class="col-6"><p>  x`+ data.barang[y].kuantitas + `</p></div>
                                                                    <div class="col-6"><p class="text-right">` + convertAngkaToRupiah(data.barang[y].subtotal) + `</p></div>
                                                                </div>
                                                        </div>
                                                    </div>`;
                                    }
                                }

                                subTotalProduk += data.barang[i].subtotal;

                                infoDetailBrg += `<h5>Pengiriman</h5>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                ` + data.pengiriman[i].jenis_pengiriman + ` ` + data.pengiriman[i].nama_shipper + `
                                                            </div>
                                                            <div class="col-12">
                                                                Estimasi pengiriman tiba ` + estimasiTiba + `
                                                            </div>
                                                            <div class="col-12">
                                                                Ongkos kirim ` + convertAngkaToRupiah(data.pengiriman[i].tarif) + `
                                                            </div>
                                                            <button class="btn btn-link text-success btnLihatInfoPengiriman" data-id="` + data.pengiriman[i].pengiriman_id + `"><strong>Lihat informasi pengiriman</strong></button>
                                                        </div>
                                                        <hr>`;
                            }

                            $('.rowContentBrg').html(infoDetailBrg);

                            $('#labelSubtotalProduk').html("Subtotal Produk :");

                            $('#subtotalProduk').html(convertAngkaToRupiah(subTotalProduk));

                            $('#labelTotalTarifOngkir').html("Total Tarif Ongkir :");

                            $('#totalTarifOngkir').html(convertAngkaToRupiah(totalTarif));

                            // if(data.barang[index].nama_shipper == 'Gojek' || data.barang[index].nama_shipper == 'Grab')
                            // {
                            //     estimasiTiba = moment(data.barang[index].estimasi_tiba).format("DD MMMM YYYY HH:mm:ss") + " WIB";
                            // }
                            // else 
                            // {
                            //     estimasiTiba = moment(data.barang[index].estimasi_tiba).format("DD MMMM YYYY");
                            // }

                        } // end if

                        $('#labelTotal').html("Total :");

                        $('#totalTransaksi').html(convertAngkaToRupiah(data.transaksi[0].total));
                        
                    }   
                });

            });


        });

    </script>
@endpush




