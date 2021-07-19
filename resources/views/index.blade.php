<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Kopkar UBAYA</title>
</head>
<body>
    {{-- navigation bar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">

        <a class="navbar-brand" href="#"><i>Kopkar UBAYA</i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <div class="dropdown mx-auto">
                <button class="btn btn-success dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Semua Jenis Produk
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>

                <form class="form-inline my-2 my-lg-0 d-inline">
                    <input class="form-control" type="search" placeholder="Cari Produk" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item">
                  <a href="#" class="nav-link active mr-3"><i class="fas fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><b>Daftar</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><b>Masuk</b></a>
                </li>
            </ul>
        </div>
    </nav>

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

            <div class="col-6 mt-2">
                <p class="h5"><b>Sedang Promo <a href="#" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
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
                    </div>
                </div>
            </div>
        </div> 

        <div class="row px-5">

            <div class="col-6 mt-2">
                <p class="h5"><b>Produk Baru <a href="#" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
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
                                        <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
                                        </div>
                                    </div>
                                </div>
    
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