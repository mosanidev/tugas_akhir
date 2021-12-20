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
                                    <img src="{{ asset($item->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                                </div>
                                <div class="col-10">
                                    <p class="barang_id d-none">{{ $item->barang_id }}</p>
                                    <p><strong class="barang_nama">{{ $item->barang_nama }}</strong></p>
                                    <div class="row">
                                        <div class="col-4">
                                            <p>Harga Satuan</p>
                                        </div>
                                        <div class="col-8">
                                            @if($item->barang_diskon_potongan_harga > 0)<del class="d-inline mr-2">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</del>@endif<p class="d-inline barang_harga">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
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
                            <p><strong>{{ "Rp " . number_format($cart[0]->total+$totalDiskon,0,',','.') }}</strong></p>
                        </div>
                        @if($totalDiskon > 0) 
                            <div class="col-7">
                                <p>Total Diskon</p>
                            </div>
                            <div class="col-5">
                                <p id="total-diskon"><strong>{{ "Rp " . number_format($totalDiskon,0,',','.') }}</strong></p>
                            </div>
                        @endif
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-7">
                            <p>Total Harga Pesanan</p>
                        </div>
                        <div class="col-5">
                            <p><strong id="total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                        </div>
                    </div>

                    <h5 class="mt-3"><strong>Alamat Pengambilan</strong></h5> 

                    <p>Minimarket KopKar</p>
                    <p class="text-justify">Jl. Raya Rungkut, Kec. Rungkut, Kota Surabaya, Jawa Timur 60293</p>
                    <p class="text-justify">Buka Hari Senin-Sabtu <br> jam 08:00 - 16:00</p>
                    <p class="text-justify" id="maks_ambil"></p>


                    <a class="btn btn-success text-light" id="pay">Beli</a><br>
                    

                </div>
            </div>

            <form action="{{ route('checkoutPickInStore') }}" method="GET" id="submitPaymentForm">
                {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
                <input type="hidden" name="nomor_nota" id="nomor_nota" value="">
            </form>

            <form action="{{ route('payment.cancel') }}" method="GET" id="cancelPaymentForm">
                {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
                <input type="hidden" name="nomor_nota" value="{{ strtoupper(substr(md5(uniqid()), 10)) }}">
            </form>

            {{-- testing midtrans --}}

            {{-- @php 

                $params = array(
                    'transaction_details' => array(
                        'order_id' => 'testing03',
                        'gross_amount' => 30000,
                    ),
                    'customer_details' => array(
                        'first_name' => auth()->user()->nama_depan,
                        'last_name' => auth()->user()->nama_belakang,
                        'email' => auth()->user()->email,
                        'phone' => auth()->user()->nomor_telepon,
                    ),
                    // 'item_details' => array()
                );


                $snapToken = \Midtrans\Snap::getSnapToken($params);


            @endphp --}}

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

            let arrBarang = createArrBarang();

            moment.locale('id');

            let tglPengambilan = moment().add(2, 'days').format("dddd, DD MMMM YYYY");

            if(tglPengambilan.includes("Minggu"))
            {
                tglPengambilan = moment().add(3, 'days').format("dddd, DD MMMM YYYY");
            }

            // $('#maks_ambil').text("Masimal pengambilan pesanan pada " + tglPengambilan + " saat jam buka minimarket");

            let nomor_nota = "{{ strtoupper(substr(md5(uniqid()), 10)) }}";

            $('#pay').on('click', function() {

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
                            onError: function () {

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

            return arrBarang;
        }

    
    </script>

@endpush