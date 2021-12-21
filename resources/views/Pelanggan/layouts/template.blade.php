<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">

    @stack('css')
    
    <title>Toko Kopkar Ubaya</title>

    <style>

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">

        
        <a class="navbar-brand" href="{{ route('home') }}"><i>Toko Kopkar Ubaya</i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <div class="mx-auto w-100" style="margin: 0 auto; float:none;">

                <form class="form-inline ml-5" method="GET" id="formCariProduk" action="{{ route('search')}}">
                    
                    <div class="dropdown d-inline mr-1">
                        <button class="btn btn-success dropdown-toggle btnPilihKategori" style="width: 300px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                          Pilih Kategori
                        </button>
                        <div class="dropdown-menu" style="height: 1180%; overflow-y: scroll;" aria-labelledby="dropdownMenuButton">
                            @foreach ($semua_kategori as $item)
                                <a class="dropdown-item" onclick="pilih('{{$item->kategori_barang}}')" id="nama_kategori">{{$item->kategori_barang}}</a>
                            @endforeach
                        </div>
                    </div>

                    <input id="search-product" class="form-control" style="width: 55%" type="search" placeholder="Cari Produk" name="key" aria-label="Search" list="barangList" autocomplete="off">
                    <input type="hidden" value="" id="input_kategori" name="input_kategori">
                    <button class="btn btn-success ml-2" onclick="check()" type="button"><i class="fa fa-search"></i></button>
                </form>

            </div>

            <ul class="navbar-nav">
                <li class="nav-item">
                </li>
                
                    @if(Auth::check())
                        <a href='{{ route('notifikasi.index') }}' class='nav-link active'><i class='fas fa-bell'></i></a>
                        <a href='{{ route('wishlist.index') }}' class='nav-link active'><i class='fas fa-heart'></i></a>
                    @endif

                    <a href="{{ url('cart') }}" class="nav-link active"><i class="fas fa-shopping-cart"></i></a>

                    @if(Auth::check())

                        @if(isset($total_cart))
                            @if(count($total_cart) > 0)   
                                <p id="total_cart" class="mr-3">{{ $total_cart[0]->total_cart }}</p>                            
                            @else
                                <p id="total_cart" class="mr-3">0</p>
                            @endif
                        @endif 

                        <li class="nav-item">
                            <div class="dropdown">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <img src="https://www.psikoma.com/wp-content/uploads/2016/07/board-361516_1280-630x380.jpg" class="rounded-circle" style="width:35px; height:30px;" alt="profil"><p class="ml-2 text-dark d-inline">{{ auth()->user()->nama_depan.' '.auth()->user()->nama_belakang }}</p>
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('profil') }}">Profil</a>
                                <a class="dropdown-item" href="{{ url('alamat') }}">Alamat</a>
                                <a class="dropdown-item" href="{{ route('order') }}">Transaksi</a>
                                <a class="dropdown-item" href="#retur">Retur</a>
                                <a class="dropdown-item" href="{{ route('wishlist.index') }}">Wishlist</a>
                                <a class="dropdown-item" href="{{ route('notifikasi.index') }}">Notifikasi</a>
                                <a class="dropdown-item" href="{{ route('logout') }}">Keluar</a>
                                </div>
                            </div>
                            {{-- <a class="nav-link" href=""><img src="https://www.psikoma.com/wp-content/uploads/2016/07/board-361516_1280-630x380.jpg" class="rounded-circle" style="width:35px; height:30px;" alt="profil"><p class="ml-2 text-dark d-inline">Muhammad Sani</p></a> --}}
                        </li>
                    @else

                        @if(session()->get('cart') != null)
                            @if(count(session()->get('cart')) > 0)   
                                <p id="total_cart" class="mr-3">{{ count(session()->get('cart')) }}</p>                            
                            @else
                                <p id="total_cart" class="mr-3">0</p>
                            @endif                        
                        @else
                            <p id="total_cart" class="mr-3">0</p>
                        @endif 

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.register') }}"><b>Daftar</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pelanggan.login') }}"><b>Masuk</b></a>
                        </li>

                    @endif
            </ul>
        </div>
    </nav>


    @yield('content')


</body>

    @include('pelanggan.modal.loader')
    @include('pelanggan.modal.custom_modal')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/scripts/helper.js') }}"></script>
    <script type="text/javascript">

        function pilih(nama)
        {
            $('.btnPilihKategori').text(nama);

            $('#input_kategori').val(nama);
        }

        function check()
        {
            // jika tidak kosong dan sudah pilih kategori maka mulai pencarian
            if(!(!$('#input_kategori').val() || !$('#search-product').val()))
            {
                $('#formCariProduk').submit();
            }
        }

        var inputSearch = document.getElementById("search-product");

        inputSearch.addEventListener("keypress", function(event) {
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
            }
        });

    </script>

    @stack('script')

</html>

