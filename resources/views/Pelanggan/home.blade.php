@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    {{-- {{session()->flush();}} --}}

    <div class="bg-secondary">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @for($i = 0; $i<count($files); $i++)
                    @if($i == 0)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="active"></li>
                    @else 
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                    @endif
                @endfor
            </ol>
            <div class="carousel-inner">
                @for($i = 0; $i<count($files); $i++)

                    @if($i == 0)
                        <div class="carousel-item active">
                            <img src="{{ asset($files[$i]) }}" style="object-fit: cover;" class="mx-auto d-block p-5" height="445" width="1240">
                        </div>
                    @else 
                        <div class="carousel-item">
                            <img src="{{ asset($files[$i]) }}" style="object-fit: cover;" class="mx-auto d-block p-5" height="445" width="1240">
                        </div>
                    @endif

                @endfor
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row p-5">
            <div class="col-12 mb-5">
                <a href="{{ route('shop') }}" class="btn btn-block btn-success mx-auto py-3 w-50" role="button">Mulai Belanja</a>
            </div>

            @if(isset($barang_promo) && count($barang_promo) > 0 && $barang_promo[0]->id != null) 
                <div class="col-6 mt-2">
                    <p class="h5"><b>Sedang Promo <a href="{{ route('promo') }}" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
                </div>

                @if(count($barang_promo) > 4)

                    <div class="col-6 text-right">
                        <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-success mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                @endif

                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    @php $barangPromoLength = count($barang_promo) > 4 ? 4 : count($barang_promo);  @endphp

                                    @for($i = 0; $i < $barangPromoLength; $i++)

                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <input type="hidden" name="barang_id" value="{{ $barang_promo[$i]->id }}">
                                                <div style="height: 150px;">
                                                    <img class="card-img-top" src="{{ asset("".$barang_promo[$i]->foto) }}" alt="Foto Produk">
                                                </div>
                                                <div class="card-body">
                                                    <div style="height: 60px;">
                                                        <p><b><a href="{{ route('detail', ['id' => $barang_promo[$i]->id]) }}" class="text-dark">{{ $barang_promo[$i]->nama }}</a></b></p>
                                                    </div>
                                                    <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_promo[$i]->harga_jual-$barang_promo[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                    <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_promo[$i]->id }}" type="button"> Beli </button>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor
        
                                </div>
                            </div>
                            @if(count($barang_promo) > 4)
                                <div class="carousel-item">
                                    <div class="row">

                                            @for($i = 4; $i < count($barang_promo); $i++)

                                                <div class="col-md-3 mb-3">
                                                    <div class="card">
                                                        <input type="hidden" name="barang_id" value="{{ $barang_promo[$i]->id }}">
                                                        <div style="height: 150px;">
                                                            <img class="card-img-top" src="{{ asset("".$barang_promo[$i]->foto) }}" alt="Foto Produk">
                                                        </div>
                                                        <div class="card-body">
                                                            <div style="height: 60px;">
                                                                <p><b><a href="{{ route('detail', ['id' => $barang_promo[$i]->id]) }}" class="text-dark">{{ $barang_promo[$i]->nama }}</a></b></p>
                                                            </div>
                                                            <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_promo[$i]->harga_jual-$barang_promo[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                            <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_promo[$i]->id }}" type="button"> Beli </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endfor

                                    </div>
                                </div>
                            @endif
                    </div>
            @endif

        <div class="row">


            @if(isset($barang_konsinyasi) && count($barang_konsinyasi) && $barang_konsinyasi[0]->id != null)
                <div class="col-6 mt-2">
                    <p class="h5 mr-3"><b>Lainnya dari kami <a href="#konsinyasi" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
                </div>

                @if(count($barang_konsinyasi) > 4)

                    <div class="col-6 text-right">
                        <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-success mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                @endif

                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    @php $barangKonsinyasiLength = count($barang_konsinyasi) > 4 ? 4 : count($barang_konsinyasi);  @endphp

                                    @for($i = 0; $i < $barangKonsinyasiLength; $i++)

                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <input type="hidden" name="barang_id" value="{{ $barang_konsinyasi[$i]->id }}">
                                                <div style="height: 150px;">
                                                    <img class="card-img-top" src="{{ asset("".$barang_konsinyasi[$i]->foto) }}" alt="Foto Produk">
                                                </div>
                                                <div class="card-body">
                                                    <div style="height: 60px;">
                                                        <p><b><a href="{{ route('detail', ['id' => $barang_konsinyasi[$i]->id]) }}" class="text-dark">{{ $barang_konsinyasi[$i]->nama }}</a></b></p>
                                                    </div>
                                                    <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_konsinyasi[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_konsinyasi[$i]->harga_jual-$barang_konsinyasi[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                    <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_konsinyasi[$i]->id }}" type="button"> Beli </button>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor
        
                                </div>
                            </div>
                            @if(count($barang_konsinyasi) > 4)
                                <div class="carousel-item">
                                    <div class="row">

                                            @for($i = 4; $i < count($barang_konsinyasi); $i++)

                                                <div class="col-md-3 mb-3">
                                                    <div class="card">
                                                        <input type="hidden" name="barang_id" value="{{ $barang_konsinyasi[$i]->id }}">
                                                        <div style="height: 150px;">
                                                            <img class="card-img-top" src="{{ asset("".$barang_konsinyasi[$i]->foto) }}" alt="Foto Produk">
                                                        </div>
                                                        <div class="card-body">
                                                            <div style="height: 60px;">
                                                                <p><b><a href="{{ route('detail', ['id' => $barang_konsinyasi[$i]->id]) }}" class="text-dark">{{ $barang_konsinyasi[$i]->nama }}</a></b></p>
                                                            </div>
                                                            <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_konsinyasi[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_konsinyasi[$i]->harga_jual-$barang_konsinyasi[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                            <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_konsinyasi[$i]->id }}" type="button"> Beli </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endfor

                                    </div>
                                </div>
                            @endif
                    </div>
            @endif

            {{-- <div class="col-12">
                <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Beli</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div> 
    </div>

@endsection

@push('script')

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            $(".add_to_cart").click(function(event) {

                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('addCart') }}',
                    data: { 'barang_id':event.target.getAttribute('data-id') },
                    beforeSend: function() {
                        toastr.remove();
                        $('#modalLoading').modal('toggle');
                        
                    },
                    success:function(data) {

                        $('#modalLoading').modal('toggle');

                        toastr.success(data.status, "Success", toastrOptions);

                        let total_cart = $("#total_cart")[0].innerText;

                        if (data.status == "Barang berhasil dimasukkan ke keranjang")
                        {
                            $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                        } 

                    },
                    error: function (err) {
                        console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                    }
                });

            });

            if("{{session('status')}}" != "")
            {
                toastr.success("{{session('status')}}", "Success", toastrOptions);
            }

        });

    </script>

@endpush