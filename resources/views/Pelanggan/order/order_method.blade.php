@extends('pelanggan.order.layouts.template')

@section('content')

    <div class="p-5 my-5" style="background-color: #FFF47D;" id="content-cart">

        <a href="{{ route('show') }}" class="btn btn-link text-success mb-3"><strong> <- Kembali ke halaman keranjang </strong></a>

        <h3 class="mb-4"><strong>Metode Transaksi</strong></h3>

        <div class="row">
            <div class="col-md-8">

                @php $totalDiskon = 0; @endphp
                {{-- load barang --}}
                @foreach($cart as $item)

                    @php $totalDiskon += $item->barang_diskon_potongan_harga*$item->kuantitas; @endphp

                    <div class="bg-light border border-4 p-3 mb-3">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset($item->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                            </div>
                            <div class="col-10">
                                <p><strong>{{ $item->barang_nama }}</strong></p>
                                
                                <div class="row">
                                    <div class="col-4">
                                        <p>Harga Satuan</p>
                                    </div>
                                    <div class="col-8">
                                        @if($item->barang_diskon_potongan_harga > 0)
                                            <del class="d-inline mr-2">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</del>    
                                        @endif
                                        <p class="d-inline">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Jumlah</p>
                                    </div>
                                    <div class="col-8">
                                        <p>{{$item->kuantitas}}</p>
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
                        <p><strong>{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                    </div>
                    {{-- @if($totalDiskon > 0) 
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
                        <p><strong>{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                    </div> --}}
                </div>
                {{-- <div class="mb-2">
                    <p class="d-inline-block text-right mr-5">Total Harga Produk</p><p class="d-inline">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p><br>
                </div> --}}
                <hr>

                <h5 class="mt-3"><strong>Pilih Metode Transaksi</strong></h5>

                <a href="{{ route('orderShipment') }}" id="btn-kirim-ke-alamat" class="btn btn-outline-success mr-2"><strong>Kirim ke Alamat</strong></a>
                <a href="{{ route('pickInStore') }}" id="btn-ambil-di-toko" class="btn btn-outline-success"><strong>Ambil di Toko</strong></a>



            </div>
        </div>
    </div>

@endsection

@push('script')

    <script type="text/javascript">

        // function jamBolehAmbilDiToko()
        // {
        //     moment().format();
        //     // moment().tz("America/Los_Angeles").format();

        //     let jamBuka = moment().startOf('day').hours('8');

        //     let jamTutup =  moment().startOf('day').hours('15');

        //     let tercakup = moment().isBetween(jamBuka, jamTutup); // true

        //     if(!tercakup)
        //     {
        //         // $('#btn-kirim-ke-alamat').click();
        //         $('#btn-ambil-di-toko').hide();
        //     }
        // }

        // jamBolehAmbilDiToko();

    </script>

@endpush