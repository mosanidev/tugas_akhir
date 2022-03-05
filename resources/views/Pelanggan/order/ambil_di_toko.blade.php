@extends('pelanggan.order.layouts.template')

@section('content')
    
    <div class="container">

        <div class="p-5 my-5" style="background-color: #FFF47D;" id="content-cart">

            @if(session('status'))
                <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button id="alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <p class="text-center"><strong>{{ session('status') }}</strong></p>
                </div>
            @endif

            <a href="{{ route('orderMethod') }}" class="btn btn-link text-success mb-3"><strong> <- Kembali ke halaman pilih metode transaksi </strong></a>

            <h3 class="mb-4"><strong>Belanja Ambil di Toko</strong></h3>

            @php $totalDiskon = 0; @endphp

            <div class="row">

                <div class="col-md-8">

                    {{-- load barang --}}
                    @foreach($cart as $item)

                        @php $totalDiskon += $item->barang_diskon_potongan_harga * $item->kuantitas; @endphp

                        <div class="bg-light border border-4 p-3 mb-3">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset($item->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" style="object-fit: contain" width="80" height="80">
                                </div>
                                <div class="col-10">
                                    <p class="barang_id d-none">{{ $item->barang_id }}</p>
                                    <p><strong class="barang_nama">{{ $item->barang_nama }}</strong></p>
                                    <div class="row">
                                        <div class="col-4">
                                            <p>Harga Satuan</p>
                                        </div>
                                        <div class="col-8">
                                            @if($item->barang_diskon_potongan_harga > 0)
                                                <del class="d-inline mr-2">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</del><p class="d-inline barang_harga">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                            @else
                                                <p class="d-inline barang_harga">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4">
                                            <p>Jumlah</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="barang_jumlah">{{$item->kuantitas}}</p>
                                        </div>
                                        <div class="col-4">
                                            <p>Subtotal</p>
                                        </div>
                                        <div class="col-8">
                                            <p>{{ "Rp " . number_format(($item->barang_harga-$item->barang_diskon_potongan_harga)*$item->kuantitas,0,',','.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                    

                </div>
                <div class="col-md-4">
                    <h5><strong>Informasi Transaksi</strong></h5> 

                    <div class="row">
                        <div class="col-7">
                            <p>Total Harga <br> ( {{ count($cart) }} Produk )</p>
                        </div>
                        <div class="col-5">
                            <p><strong id="total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            Jumlah
                        </div>
                        <div class="col-5">
                            <p><strong id="total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                        </div>
                    </div>
                    
                    <hr>

                    <h5 class="mt-3"><strong>Alamat Pengambilan</strong></h5> 

                    <p>Minimarket KopKar</p>
                    <p class="text-justify">Jl. Raya Rungkut, Kec. Rungkut, Kota Surabaya, Jawa Timur 60293</p>
                    <p class="text-justify">Buka Hari Senin-Sabtu <br> jam 08:00 - 16:00</p>
                    <p class="text-justify" id="maks_ambil"></p>

                    <a class="btn btn-success text-light" id="pay">Beli</a><br>

                    {{-- @if(auth()->user()->jenis == "Pelanggan")
                    @else  
                        anggota kopkar
                        <button class="btn btn-success text-light" data-toggle="modal" data-target="#modalBeliAnggotaKopkar">Beli</button>
                    @endif --}}

                </div>
            </div>
            
            @if(auth()->user()->jenis == "Anggota_Kopkar")
                @include('pelanggan.order.modal.choose_payment')
            @endif

            <form action="{{ route('checkoutPickInStore') }}" method="GET" id="submitPaymentForm">
                <input type="hidden" name="nomor_nota" id="nomor_nota" value="">
            </form>

            <form action="{{ route('payment.cancel') }}" method="GET" id="cancelPaymentForm">
                {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
                <input type="hidden" name="nomor_nota" value="{{ strtoupper(substr(md5(uniqid()), 10)) }}">
            </form>

        </div>
    </div>



@endsection

@push('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KVse50bzjErTjsM8"></script>
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            const total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

            console.log(total_pesanan);

            let arrBarang = createArrBarang();

            let nomor_nota = "{{ strtoupper(substr(md5(uniqid()), 10)) }}";

            $('#pay').on('click', function() {

                if($('#modalBeliAnggotaKopkar').hasClass('show'))
                {
                    $('#modalBeliAnggotaKopkar').modal('toggle');
                }

                // loading . . .
                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('initPayment') }}',
                    data: { 'total_pesanan': total_pesanan, 'nomor_nota': nomor_nota, 'arr_barang': arrBarang},
                    success:function(data) {

                        $('#nomor_nota').val(nomor_nota);

                        window.snap.pay(data.snapToken, {
                            onSuccess: function (result) {

                                // console.log(result);
                                // $('#modalLoading').modal('toggle');
                                $('#submitPaymentForm').submit();

                            },
                            onPending: function (result) {

                                // console.log(result);
                                // $('#modalLoading').modal('toggle');
                                $('#submitPaymentForm').submit();

                            },
                            onError: function (result) {

                                // console.log(result);
                                $('#modalLoading').modal('toggle');

                            },
                            onClose: function() {

                                $('#modalLoading').modal('toggle');

                            },
                            gopayMode: 'qr'
                        });
                        
                    } 
                });

            });

        });

        $('#payPotongGaji').on('click', function() {

            const total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

            let arrBarang = createArrBarang();

            let nomor_nota = "{{ strtoupper(substr(md5(uniqid()), 10)) }}";

            $('#arrBarang').val(JSON.stringify(arrBarang));
            
            $('#totalPesanan').val(total_pesanan);

            $('#nomorNota').val(nomor_nota);

            $('#metodeTransaksi').val("Ambil di toko");

            $('#modalBeliAnggotaKopkar').modal('toggle');

            // loading . . .
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

            $('#payPotongGaji').attr('type', 'submit');
            $('#payPotongGaji')[0].click();

        });

        function createArrBarang()
        {
            let arrBarang = { "item_details" : [] };

            for(let i = 0; i < $('.barang_id').length; i++)
            {
                let obj = { 
                    "id": $('.barang_id')[i].innerHTML,
                    "price": convertRupiahToAngka($('.barang_harga')[i].innerHTML),
                    "quantity": $('.barang_jumlah')[i].innerHTML,
                    "name": $('.barang_nama')[i].innerHTML
                }
                arrBarang.item_details.push(obj)
            }

            if($('#total-diskon').html() != undefined)
            {
                let obj = {
                    id: "D01",
                    price: convertRupiahToAngka($('#total-diskon').html()),
                    quantity: 1,
                    name: "Discount"
                }
                arrBarang.item_details.push(obj)
            }

            return arrBarang;
        }

    
    </script>

@endpush