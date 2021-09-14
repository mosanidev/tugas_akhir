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

        <div class="row pt-5 pb-1">

            <div id="filter" class="col-3 border">
                <div class="py-2">
                    <div class="mb-2 my-2">

                        @yield('sidebar')

                    </div>        
                </div>
            </div>

            <div class="col-md-9 d-inline">
                <div class="col-md-12">
                    <p class="text-right">URUTKAN BERDASARKAN&nbsp; 
                        <select class="form-control d-inline" style="width: 250px;">
                            <option value="" selected>ALFABET A-Z</option>
                            <option value="">ALFABET Z-A</option>
                            <option value="">HARGA TERENDAH</option>
                            <option value="">HARGA TERTINGGI</option>
                            <option value="">PROMO</option>
                            <option value="">PENJUALAN TERBANYAK</option>
                        </select>
                    </p>
                </div>

                <div class="row">

            
                    <?php $barang = isset($barang_filtered) ? $barang_filtered : $barang; ?>

                    @if(count($barang) == 0) 

                        <p class="p-3 h5">Maaf barang kosong</p>
                    
                    @else

                        @for($i=0; $i<count($barang); $i++)

                            <div class="col-md-4 mb-3">
                                <div class="card" style="">
                                    <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
                                    <div class="card-body">
                                    <p><b><a href="{{ route('detail', ['id' => $barang[$i]->id]) }}" class="text-dark">{{ $barang[$i]->nama }}</a></b></p>
                                    @if($barang[$i]->diskon_potongan_harga != 0)
                                    <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang[$i]->diskon_potongan_harga+$barang[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</p>
                                    @else
                                        <p class="card-text">{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</p>
                                    @endif
                                    <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
                                    </div>
                                </div>
                            </div>

                        @endfor

                    @endif 
            </div>
        </div>

        <nav class="float-right">
            <ul class="pagination">
              <li class="page-item"><a class="page-link text-success" href="#">Previous</a></li>
              <li class="page-item"><a class="page-link text-success" href="#">1</a></li>
              <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
              <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
              <li class="page-item"><a class="page-link text-success" href="#">Next</a></li>
            </ul>
        </nav>
        
    </div>
      
</body>
<script type="text/javascript">


    

</script>
</html>