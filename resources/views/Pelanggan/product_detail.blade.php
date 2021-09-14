<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>SEVEN SHOP</title>
</head>
<body>
    {{-- navigation bar --}}
    @include('pelanggan.navbar')
    
    <div class="container"> 

        <div class="p-5 my-5" style="background-color: #FFF47D">
            <div class="row">
                <div class="col-md-4">
                    <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded" alt="Foto Produk" width="350" height="300">
                </div>
                <div class="col-md-8">
                    <div class="ml-5">
                            <h5>{{ $barang[0]->jenis_barang }}</h5>
                            <h3><strong>{{ $barang[0]->nama }}</strong></h3> 
                            @if($barang[0]->diskon_potongan_harga != 0)
                                <p><del class="mr-2">{{ "Rp " . number_format($barang[0]->diskon_potongan_harga+$barang[0]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang[0]->harga_jual,0,',','.') }}</p>
                            @else
                                <p>{{ "Rp " . number_format($barang[0]->harga_jual,0,',','.') }}</p>
                            @endif  
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Kategori</p><p class="d-inline">{{ $barang[0]->kategori_barang }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Kode</p><p class="d-inline">{{ $barang[0]->kode }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Merek</p><p class="d-inline">{{ $barang[0]->merek_barang }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Stok</p><p class="d-inline">{{ $barang[0]->jumlah_stok }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Satuan</p><p class="d-inline">{{ $barang[0]->satuan }}</p><br>
                            <p class="d-inline-block mr-5" style="width: 7%; height:15px;">Berat</p><p class="d-inline">{{ $barang[0]->berat }} gram</p><br>
                            <p class="mb-2">Deskripsi</p>
                            <p class="text-justify">{{ $barang[0]->deskripsi }}</p>
                            
                        <form method="POST" action="{{ route('addCart') }}">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $barang[0]->id }}">
                            <button class="btn btn-success mt-3">Tambahkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
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
                                                <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
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
                                                <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
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
                                                    <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
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
                                                <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
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

    </div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>