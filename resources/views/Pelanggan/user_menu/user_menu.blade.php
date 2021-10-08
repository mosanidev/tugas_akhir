<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('logout') }}">Keluar</a>
            </div>
            <div class="col-9 mt-2" style="background-color: #FFF47D;">

                @if(isset($profil))

                    @include('pelanggan.user_menu.profil')

                @elseif(isset($alamat))

                    @include('pelanggan.user_menu.alamat')

                @elseif(isset($order))

                    @include('pelanggan.user_menu.order')
                    
                @elseif(isset($status))

                    <script>alert({{ $status }})</script>

                @endif
                
            </div>
        </div>
    </div>

</body>
</html>