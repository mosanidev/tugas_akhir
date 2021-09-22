<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@if(session('status') != null)

    {{-- <script>alert("{{ session()->get('status') }}")</script> --}}
    <div class="alert alert-danger" role="alert">
        {{session()->get('status')}}
    </div>

@endif


<nav class="navbar navbar-expand-lg navbar-light bg-warning">

    <a class="navbar-brand" href="{{ route('home') }}"><i>SEVEN SHOP</i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <div class="mx-auto w-50">

            <form class="form-inline ml-5" method="POST" action="{{ route('search')}}">
                @csrf
                <input id="search-product" class="form-control" style="width: 90%" type="search" placeholder="Cari Produk" name="nama_barang_search" aria-label="Search" list="barangList" autocomplete="off">
                <datalist id="barangList">
                    
                    @if(isset($barang))

                        @for($i=0; $i<count($barang); $i++)
                            <option>{{ $barang[$i]->nama }}</a></option>
                        @endfor

                    @endif
                    
                </datalist>
                <button class="btn btn-success ml-2" type="submit"><i class="fa fa-search"></i></button>
            </form>

        </div>

        <ul class="navbar-nav">
            <li class="nav-item">
            </li>
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
                        <a class="nav-link" href="{{ route('register') }}"><b>Daftar</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><b>Masuk</b></a>
                    </li>

                @endif
        </ul>
    </div>
</nav>
<script type="text/javascript">

    function convertAngkaToRupiah(angka)
    {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function convertRupiahToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

</script>