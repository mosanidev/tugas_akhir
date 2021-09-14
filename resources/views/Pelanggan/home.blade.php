<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>SEVEN SHOP</title>
</head>
<body>

    {{-- navigation bar --}}
    @include('pelanggan.navbar')

    <div class="bg-secondary">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://assets.klikindomaret.com/products/banner/HERO_BNR_KLiK-FOOD-JULI%20_1_.jpg" class=" w-75 img-fluid mx-auto d-block p-4" alt="Responsive image">
            </div>
            <div class="carousel-item">
                <img src="https://assets.klikindomaret.com/products/banner/HERO_BNR_TEBUS-MURAH-7-JUL_4.jpg" class=" w-75 img-fluid mx-auto d-block p-4" alt="Responsive image">
            </div>
            <div class="carousel-item">
                <img src="https://assets.klikindomaret.com/products/banner/HERO_BNR_BEAR-BRAND-8-JULI.jpeg" class=" w-75 img-fluid mx-auto d-block p-4" alt="Responsive image">
            </div>
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

            <div class="col-6 mt-2">
                <p class="h5"><b>Sedang Promo <a href="{{ route('promo') }}" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a class="btn btn-success mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
    
            <div class="col-12">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">


                                @if(isset($data_barang_promo))
                                    @for($i = 0; $i < count($data_barang_promo)-5; $i++)

                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="">
                                                <input type="hidden" name="barang_id" value="{{ $data_barang_promo[$i]->id }}">
                                                <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                <div class="card-body">
                                                <p><b><a href="{{ route('detail', ['id' => $data_barang_promo[$i]->id]) }}" class="text-dark">{{ $data_barang_promo[$i]->nama }}</a></b></p>
                                                <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($data_barang_promo[$i]->diskon_potongan_harga+$data_barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($data_barang_promo[$i]->harga_jual,0,',','.') }}</p>
                                                {{-- <p class="card-text"></p> --}}
                                                <button class="btn btn-block btn-success add_to_cart_promo" id="btn-add-cart-{{  $data_barang_promo[$i]->id }}" type="button">Tambahkan ke Keranjang</button>

                                                </div>
                                            </div>
                                        </div>

                                    @endfor
                                @endif

                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row">

                                @if(isset($data_barang_promo))

                                    @for($i = 4; $i < count($data_barang_promo); $i++)

                                        <div class="col-md-3 mb-3">
                                            <div class="card" style="">
                                                <input type="hidden" name="barang_id" value="{{ $data_barang_promo[$i]->id }}">
                                                <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                                <div class="card-body">
                                                <p><b><a href="{{ route('detail', ['id' => $data_barang_promo[$i]->id]) }}" class="text-dark">{{ $data_barang_promo[$i]->nama }}</a></b></p>
                                                <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($data_barang_promo[$i]->diskon_potongan_harga+$data_barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($data_barang_promo[$i]->harga_jual,0,',','.') }}</p>
                                                {{-- <p class="card-text"></p> --}}
                                                @if(Auth::check())
                                                    <button class="btn btn-block btn-success add_to_cart_promo" type="button" id="btn-add-cart-{{  $data_barang_promo[$i]->id }}">Tambahkan ke Keranjang</button>
                                                @else
                                                    <a href="{{ route('login') }}" class="btn btn-block btn-success">Tambahkan ke Keranjang</a>
                                                @endif

                                                </div>
                                            </div>
                                        </div>

                                    @endfor
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <div class="row px-5">

            <div class="col-6 mt-2">
                <p class="h5"><b>Penjualan Terbanyak <a href="#" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
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
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
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
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                        <div class="card-body">
                                        <p><b>Nama Produk</b></p>
                                        <p class="card-text">Rp 15.000</p>
                                        <button class="btn btn-block btn-success add_to_cart_top_penjualan" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
      
</body>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $(".add_to_cart_promo").click(function(event) {

        event.preventDefault();

        const barang_id = document.getElementsByName("barang_id");

        let barang_id_ = null;

        for (let i = 0; i<$(".add_to_cart_promo").length; i++) 
        {
            if(barang_id[i].value == event.target.id.split("-")[3])
            {
                barang_id_ = event.target.id.split("-")[3];
            }
        }

        $.ajax({
            type: 'POST',
            url: '{{ route('addCart') }}',
            data: { 'barang_id':barang_id_ },
            success:function(data) {
                    alert(data.status);

                    let total_cart = $("#total_cart")[0].innerText;

                    if (data.status == "Barang berhasil dimasukkan ke keranjang")
                    {
                        $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                    } 

                }
            });
        });
    });
    
    
</script>
</html>