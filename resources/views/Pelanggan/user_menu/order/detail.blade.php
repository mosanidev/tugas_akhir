<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.5.0/dist/geosearch.css"/>
    <title>SEVEN SHOP</title>
</head>
<body>

    {{-- navigation bar --}}
    @include('pelanggan.navbar')

    <div class="container py-5">
        <div class="row">
            <div class="col-3">
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('profil') }}">Profil</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ url('alamat') }}">Alamat</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('order') }}">Transaksi</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="#retur">Retur</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('wishlist.index') }}">Wishlist</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('notifikasi.index') }}">Notifikasi</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('logout') }}">Keluar</a>
            </div>
            <div class="col-9 mt-2" style="background-color: #FFF47D;">

                <div class="px-3 py-4">
                    <h5 class="mb-3"><strong>Detail</strong></h5>
            

                    <div id="container-order">
                        <div class="content-order">
                            <div class="row">
                                <div class="col-2">
                                    <p>Nomor Nota</p>
                                    <p>Tanggal</p>
                                    <p>Tipe</p>
                                    <p>Metode Bayar</p>
                                    <p>Status</p>
                                    <p>Total</p>
                                </div>
                                <div class="col-8">
                                    <p>{{$transaksi[0]->nomor_nota}}</p>
                                    <p>{{Carbon\Carbon::parse($transaksi[0]->tanggal)->isoFormat('DD MMMM Y')}}</p>
                                    <p>{{ ucfirst(str_replace("_", " ", $transaksi[0]->metode_transaksi)) }}</p>
                                    <p>{{ $transaksi[0]->metode_pembayaran }}</p>
                                    <p>{{ ucfirst(str_replace("_", " ",$transaksi[0]->status)) }}</p>
                                    <p>{{ "Rp " . number_format($barang[0]->total,0,',','.') }}</p> 
                                </div>
                            </div>
                            <table class="table table-striped bg-light">
                                <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Kuantitas</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $num = 1 @endphp
                                    @for($i = 0; $i<count($barang); $i++) 
                                        <tr>
                                            <td style="width: 10%;">{{ $num++ }}</td>
                                            <td><img src="{{ asset($barang[$i]->foto_1) }}" class="rounded" alt="Foto Produk" width="80" height="80">{{ $barang[$i]->nama }}</td>
                                            <td>{{ $barang[$i]->kuantitas }}</td>
                                            <td>{{"Rp " . number_format($barang[$i]->subtotal,0,',','.') }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>






