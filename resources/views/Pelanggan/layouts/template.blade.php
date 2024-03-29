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

    <style>

        .ulStar {
            list-style-type: none;
        }

        .liStar {
            float: left;
        }

        .starRating {
            font-size: 35px;
        }

        .hovered-stars {
            color: orange;
        }

        .clicked-stars {
            color: orange;
        }

    </style>

    @stack('css')
    
    <title>Toko Kopkar Ubaya</title>

</head>
<body>

    <nav class="text-right" style="background-color: #F0F0F0;">
        <a href="{{ url('/tentang_kami') }}" class="btn btn-link text-dark text-right" style="font-size: 13px;">Tentang Kami</a>
        <a href="{{ route('testimoni.index') }}" class="btn btn-link text-dark text-right" style="font-size: 13px;">Testimoni</a>
    </nav>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">

        <a class="navbar-brand" href="{{ route('home') }}"><i>Toko Kopkar Ubaya</i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <div class="mx-auto w-100" style="margin: 0 auto; float:none;">

                <form class="form-inline ml-5" method="GET" id="formCariProduk" action="{{ route('search')}}">
                    
                    <div class="dropdown d-inline mr-1">
                        <button class="btn btn-success dropdown-toggle btnPilihKategori" style="width: 250px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                            @if(isset($_GET['input_kategori']) && $_GET['input_kategori'] != "")
                                
                                @php $keteranganPilihKategori = ""; @endphp

                                @foreach ($semua_kategori as $item)
                                    @if($item->kategori_barang == $_GET['input_kategori'])
                                        @php 
                                            $keteranganPilihKategori = $_GET['input_kategori']; 
                                            break;
                                        @endphp
                                    @else 
                                        @php $keteranganPilihKategori = "Pilih Kategori"; @endphp
                                    @endif
                                @endforeach

                                {{ $keteranganPilihKategori }}
                            @else
                                Pilih Kategori
                                
                            @endif
                        </button>
                        <div class="dropdown-menu" style="overflow-y: scroll;" aria-labelledby="dropdownMenuButton">
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

                        @if(isset($jumlah_notif_belum_dilihat))

                            @if($jumlah_notif_belum_dilihat[0]->jumlah_notif > 0)   
                                <a href='{{ route('notifikasi.index') }}' class='nav-link active'><i class='fas fa-bell'></i></a>
                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill mr-1" viewBox="0 0 14 14">
                                    <circle cx="5" cy="5" r="5" class="text-success"/>
                                </svg>
                                
                            @else
                                <a href='{{ route('notifikasi.index') }}' class='nav-link active'><i class='fas fa-bell'></i></a>
                            @endif
                        @endif 

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
                                    <img src="{{ asset(auth()->user()->foto) }}" class="rounded-circle" style="width:35px; height:30px;" alt="profil"><p class="ml-2 text-dark d-inline">{{ auth()->user()->nama_depan.' '.auth()->user()->nama_belakang }}</p>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('profil') }}">Profil</a>
                                    <a class="dropdown-item" href="{{ url('alamat') }}">Alamat</a>
                                    <a class="dropdown-item" href="{{ route('order') }}">Transaksi</a>
                                    <a class="dropdown-item" href="{{ route('returPenjualan.showForm') }}">Retur</a>
                                    <a class="dropdown-item" href="{{ route('returPenjualan.showHistory') }}">Riwayat Retur</a>
                                    <a class="dropdown-item" href="{{ route('wishlist.index') }}">Favorit</a>

                                    @if(isset($jumlah_notif))
                                        @if($jumlah_notif[0]->jumlah_notif > 0)   
                                        <a class="dropdown-item" href="{{ route('notifikasi.index') }}">Notifikasi ({{ $jumlah_notif[0]->jumlah_notif }})</a>
                                        @else
                                            <a class="dropdown-item" href="{{ route('notifikasi.index') }}">Notifikasi</a>                                    
                                        @endif
                                    @endif 
        
                                    <a class="dropdown-item" href="{{ route('logout') }}">Keluar</a>
                                </div>
                            </div>

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

    <footer class="sticky-footer bg-white py-4">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span class="text-secondary">Copyright &copy; Your Website 2021</span>
            </div>
        </div>
    </footer>

</body>

    @include('pelanggan.modal.loader')
    @include('pelanggan.modal.custom_modal')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            if($('.btnPilihKategori').text().trim() != "Pilih Kategori" && $('#search-product').val() != "")
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

        $(".liStar").mouseover(function() {

            $('.liStar').css('cursor', 'pointer');

            let current = $(this);

            $(".liStar").each(function(index) {

                $(this).addClass('hovered-stars');

                if(index == current.index())
                {
                    return false;
                }
            });
        });

        $('.liStar').mouseleave(function() {

            $('.liStar').removeClass('hovered-stars');

        });

        $('.liStar').click(function() {

            $('.liStar').removeClass('clicked-stars');
            $('.hovered-stars').addClass('clicked-stars');

            let skalaRating = $('.clicked-stars').length;

            $('#skala_rating').val(skalaRating); 
        });

        $('#btnSimpanTesti').on('click', function() {

            let skalaRating = $('#skala_rating').val();

            if(skalaRating == "")
            {
                toastr.error("Harap berikan penilaian dengan mengisi bintang terlebih dahulu", "Gagal", toastrOptions);
            }
            else if($('#testi').val() == "")
            {
                toastr.error("Harap isi testimoni terlebih dahulu", "Gagal", toastrOptions);
            }
            else 
            {
                $('#formTambahTesti').submit();
                $('#modalTestimoni').modal('toggle');
                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
            }

        });

    </script>

    @stack('script')

</html>

