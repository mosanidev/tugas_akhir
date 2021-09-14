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

        <div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;">
            <h3 class="mb-4"><strong>Pilih metode pengiriman</strong></h3>

            <div class="row">
                <div class="col-md-4">
                    <h5>Alamat Pengambilan</h5> 

                    <p>Minimarket KopKar</p>
                    <p>Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>

                </div>
                <div class="col-md-8">

                     {{-- load barang --}}
                    @foreach($cart as $item)
                      <div class="bg-light border border-4 p-3 mb-3">
                        <div class="row">
                          <div class="col-2">
                            <img src="{{ $item->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                          </div>
                          <div class="col-10">
                            <p>{{ $item->barang_nama }}</p>
                            <p>{{$item->kuantitas}} barang ( {{$item->kuantitas*$item->barang_berat}} {{ $item->barang_satuan }} )</p>
                            <p>{{ "Rp " . number_format($item->barang_harga*$item->kuantitas,0,',','.') }}</p>
                          </div>
                        </div>

                      </div>
                    @endforeach

                    <p class="d-inline-block text-right mr-5 text-left" style="width: 60%; height:1px;">Total Harga Produk</p><p class="d-inline">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p><br>
                    <p class="d-inline-block text-right mr-5 text-left" style="width: 60%; height:1px;">Total Harga Pesanan</p><p class="d-inline">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p><br>
                    

                  </div>
            </div>
            

        </div>
    </div>
      
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>