@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    <div class="container">
        <div class="p-5 my-5" style="background-color: #FFF47D">

            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($barang[0]->foto) }}" class="rounded" alt="Foto Produk" width="350" height="300">
                </div>
                <div class="col-md-8">
                    <div class="ml-5">
                            <h5><strong>{{ $barang[0]->jenis_barang }}</strong></h5>
                            <h3><strong>{{ $barang[0]->nama }}</strong></h3> 
                            @if($barang[0]->diskon_potongan_harga != 0)
                                <p><del class="mr-2">{{ "Rp " . number_format($barang[0]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang[0]->harga_jual-$barang[0]->diskon_potongan_harga,0,',','.') }}</p>
                            @else
                                <p>{{ "Rp " . number_format($barang[0]->harga_jual,0,',','.') }}</p>
                            @endif  
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Kategori</p><p class="d-inline">{{ $barang[0]->kategori_barang }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Kode</p><p class="d-inline">{{ $barang[0]->kode }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Merek</p><p class="d-inline">{{ $barang[0]->merek_barang }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Satuan</p><p class="d-inline">{{ $barang[0]->satuan }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Berat</p><p class="d-inline">{{ $barang[0]->berat }} gram</p><br>
                            <p class="mb-2">Deskripsi</p>
                            <div class="bg-light p-2 mb-3 rounded">
                                <p class="text-justify">{{ $barang[0]->deskripsi }}</p>
                            </div>
 
                            <p class="d-inline">Jumlah </p><button type="button" class="btn btn-info d-inline btn-qty-min"> - </button><input type="number" class="form-control d-inline text-center" id="kuantitas-cart" style="width:63px; padding-bottom: 8.3px;" min="1" max="{{$barang[0]->jumlah_stok}}" value="1"><button type="button" class="btn btn-info d-inline btn-qty-plus mr-2" data-max="{{ $barang[0]->jumlah_stok }}"> + </button>

                            {{-- <p class="d-inline">Stok</p> <p class="d-inline"><strong>{{$barang[0]->jumlah_stok}}</strong></p> --}}
                            
                            <input type="hidden" name="barang_id" id="barangID" value="{{ $barang[0]->id }}">
                            <button class="btn btn-success ml-3" type="button" id="btnBeli" style="width:40%;">Masukkan ke keranjang</button>

                        @if(isset($data_barang_wishlist))
                            {{-- <button type="button" id="wishlist" data-id="{{ $barang[0]->id }}" class="btn btn-success ml-3"><i class="far fa-heart mr-2"></i>Wishlist</button> --}}

                            @if(count($data_barang_wishlist) > 0) 
                            
                                <form method="POST" class="d-inline" action="{{ route('wishlist.destroy', ['wishlist'=>$data_barang_wishlist[0]->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-success ml-3"><i class="fas fa-heart mr-2"></i>Wishlist</button>
                                </form>

                            @else 

                                <form method="POST" class="d-inline" action="{{ route('wishlist.store') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $barang[0]->id }}"/>
                                    <input type="hidden" name="harga_barang" value="{{ $barang[0]->harga_jual-$barang[0]->diskon_potongan_harga }}"/>
                                    <button type="submit" class="btn btn-success ml-3"><i class="far fa-heart mr-2"></i>Wishlist</button>
                                </form>

                            @endif 
                        @endif
                        
                        <p id="message" class="text-danger">@if($barang[0]->jumlah_stok <= 3) {{ "Sisa jumlah stok ".$barang[0]->jumlah_stok }} @endif</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if(isset($barang_serupa) && count($barang_serupa) > 0)
            <div class="p-3 mb-5" style="background-color: #FFF47D">
                <div class="row">
                    <div class="col-6 mt-2">
                        <p class="h5"><strong>Produk Serupa</strong></p>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-success mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
            
                    <div class="col-12">
                        <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
            
                                        @for($i = 0; $i < count($barang_serupa)-4; $i++)

                                            <div class="col-md-3 mb-3">
                                                <div class="card" style="">
                                                    <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                    <div class="card-body">
                                                    <p><b><a href="{{ route('detail', ['id' => $barang_serupa[$i]->id]) }}" class="text-dark">{{ $barang_serupa[$i]->nama }}</a></b></p>
                                                    @if($barang_serupa[$i]->diskon_potongan_harga != 0)
                                                        <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_serupa[$i]->diskon_potongan_harga+$barang_serupa[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_serupa[$i]->harga_jual,0,',','.') }}</p>
                                                    @else
                                                        <p class="card-text">{{ "Rp " . number_format($barang_serupa[$i]->harga_jual,0,',','.') }}</p>
                                                    @endif
                                                    <button class="btn btn-block btn-success add_to_cart" type="submit">Beli</button>
                                                    </div>
                                                </div>
                                            </div>

                                        @endfor
                                        
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    
                                    <div class="row">
                                        
                                        @for($i = 4; $i < count($barang_serupa); $i++)

                                            <div class="col-md-3 mb-3">
                                                <div class="card" style="">
                                                    <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                    <div class="card-body">
                                                        <p><b><a href="{{ route('detail', ['id' => $barang_serupa[$i]->id]) }}" class="text-dark">{{ $barang_serupa[$i]->nama }}</a></b></p>
                                                        @if($barang_serupa[$i]->diskon_potongan_harga != 0)
                                                        <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_serupa[$i]->diskon_potongan_harga+$barang_serupa[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_serupa[$i]->harga_jual,0,',','.') }}</p>
                                                    @else
                                                        <p class="card-text">{{ "Rp " . number_format($barang_serupa[$i]->harga_jual,0,',','.') }}</p>
                                                    @endif
                                                    <button class="btn btn-block btn-success add_to_cart" type="submit">Beli</button>
                                                    </div>
                                                </div>
                                            </div>

                                        @endfor

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        @endif

        @if(isset($barang_lain) && count($barang_lain) > 0)

            <div class="p-3 mb-5" style="background-color: #FFF47D">
                <div class="row">
                    <div class="col-6 mt-2">
                        <p class="h5"><strong>Produk Lainnya</strong></p>
                    </div>
                    <div class="col-6 text-right">
                        <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators4" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-success mb-3 " href="#carouselExampleIndicators4" role="button" data-slide="next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
            
                    <div class="col-12">
                        <div id="carouselExampleIndicators4" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
            
                                        @for($i = 0; $i < count($barang_lain)-4; $i++)

                                            <div class="col-md-3 mb-3">
                                                <div class="card" style="">
                                                    <form method="POST" action="{{ route('addCart') }}">
                                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                        <div class="card-body">
                                                        <p><b><a href="{{ route('detail', ['id' => $barang_lain[$i]->id]) }}" class="text-dark">{{ $barang_lain[$i]->nama }}</a></b></p>
                                                        @if($barang_lain[$i]->diskon_potongan_harga != 0)
                                                            <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_lain[$i]->diskon_potongan_harga+$barang_lain[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_lain[$i]->harga_jual,0,',','.') }}</p>
                                                        @else
                                                            <p class="card-text">{{ "Rp " . number_format($barang_lain[$i]->harga_jual,0,',','.') }}</p>
                                                        @endif
                                                        <button class="btn btn-block btn-success add_to_cart" type="submit">Beli</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        @endfor
                                        
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    
                                    <div class="row">

                                        @for($i = 4; $i < count($barang_lain); $i++)

                                            <div class="col-md-3 mb-3">
                                                <div class="card" style="">
                                                    <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                    <div class="card-body">
                                                    <p><b><a href="{{ route('detail', ['id' => $barang_lain[$i]->id]) }}" class="text-dark">{{ $barang_lain[$i]->nama }}</a></b></p>
                                                    @if($barang_lain[$i]->diskon_potongan_harga != 0)
                                                        <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_lain[$i]->diskon_potongan_harga+$barang_lain[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_lain[$i]->harga_jual,0,',','.') }}</p>
                                                    @else
                                                        <p class="card-text">{{ "Rp " . number_format($barang_lain[$i]->harga_jual,0,',','.') }}</p>
                                                    @endif
                                                    <button class="btn btn-block btn-success add_to_cart" type="submit">Beli</button>
                                                    </div>
                                                </div>
                                            </div>

                                        @endfor
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

            if("{{session('status')}}" != "")
            {
                toastr.success("{{session('status')}}", "Success", toastrOptions);

            }

            $(".btn-qty-min").on('click', function(event) {

                event.preventDefault();

                // let index = $(this).index('.btn-qty-min');

                if($('#kuantitas-cart').val() > 1)  
                {
                    $('#kuantitas-cart').val( $('#kuantitas-cart').val() - 1 );
                }

                console.log($('#kuantitas-cart').val());

            });

            // $('#wishlist').on('click', function() {

                // alert($('#wishlist').attr('data-id'));
                // console.log($('#wishlist').children()[0].attr('class'));

                // $.ajax({
                //     type: 'POST',
                //     url: '{{ route('addCart') }}',
                //     data: { 'barang_id': $('#barangID').val(), 'qty': $('#kuantitas-cart').val() },
                //     success:function(data) {

                //         toastr.success(data.status, "Success", toastrOptions);

                //         let total_cart = $("#total_cart")[0].innerText;

                //         if (data.status == "Barang berhasil dimasukkan ke keranjang")
                //         {
                //             $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                //         } 

                //     },
                //     error: function (err) {
                //         console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                //     }
                // });

            // });

            $('#kuantitas-cart').on('keydown keyup', function(event) {

                // let index = $(this).index('#kuantitas-cart');

                if(event.which==38 || event.which==40){
                    event.preventDefault();
                }

                if($('#kuantitas-cart').val() == "")
                {
                    $('#message').text("Harap mengisikan jumlah barang");
                }
                else if($('#kuantitas-cart').val() < 1)
                {
                    $('#message').text("Minimal pembelian 1 barang");
                }
                else if(parseInt($('#kuantitas-cart').val()) > parseInt($('#kuantitas-cart').attr('max')))
                {
                    $('#message').text("Maksimal pembelian " + $('#kuantitas-cart').attr('max') + " barang");
                }
                else 
                {
                    $('#message').text("");
                }

            });

            $('#kuantitas-cart').on('change', function(event) {

                $('#message').text("");

                if($('#kuantitas-cart').val() == "" || $('#kuantitas-cart').val() <= 0)
                {
                    $('#kuantitas-cart').val("1");
                    
                }
                else if(parseInt($('#kuantitas-cart').val()) > parseInt($('#kuantitas-cart').attr('max')))
                {
                    $('#kuantitas-cart').val($('#kuantitas-cart').attr('max'));
                }


            });

            $(".btn-qty-plus").on('click', function(event) {

                event.preventDefault();

                let max = $(this).attr("data-max");

                let tambahSatu = parseInt($('#kuantitas-cart').val()) + 1;

                if(tambahSatu <= max)
                {
                    $('#kuantitas-cart').val(tambahSatu);
                }

            });


            $('#btnBeli').on('click', function() {

                // console.log($('#kuantitasCart').val());

                $.ajax({
                    type: 'POST',
                    url: '{{ route('addCart') }}',
                    data: { 'barang_id': $('#barangID').val(), 'qty': $('#kuantitas-cart').val() },
                    success:function(data) {

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

            
            
        });

    </script>
@endpush