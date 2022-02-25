@extends('pelanggan.layouts.template')

@push('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if(isset($alamat))
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.5.0/dist/geosearch.css"/>
    @endif

    @if(isset($retur_penjualan))
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endif

@endpush

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-3">
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('profil') }}">Profil</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ url('alamat') }}">Alamat</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('order') }}">Transaksi</a>
                <a class="btn btn-block btn-success btn-lg my-2 d-block" href="{{ route('returPenjualan.showForm') }}">Retur</a>
                <a class="btn btn-block btn-success btn-lg my-2 d-block" href="{{ route('returPenjualan.showHistory') }}">Riwayat Retur</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('wishlist.index') }}">Favorit</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('notifikasi.index') }}">Notifikasi</a>
                <a class="btn btn-block btn-success btn-lg my-2" href="{{ route('logout') }}">Keluar</a>
            </div>
            <div class="col-9 mt-2" style="background-color: #FFF47D;">

                @if(isset($profil))

                    @include('pelanggan.user_menu.profil')

                @elseif(isset($alamat))

                    @include('pelanggan.user_menu.alamat')

                @elseif(isset($penjualan))

                    @include('pelanggan.user_menu.order.order')

                @elseif(isset($retur_penjualan))

                    @include('pelanggan.user_menu.retur_penjualan')

                @elseif(isset($riwayat_retur) && isset($alamat_tujuan_retur))

                    @include('pelanggan.user_menu.riwayat_retur_penjualan')

                @elseif(isset($wishlist))

                    @include('pelanggan.user_menu.wishlist')

                @elseif(isset($notifikasi))

                    @include('pelanggan.user_menu.notifikasi')
                    
                @elseif(isset($status))

                    <script>alert({{ $status }})</script>

                @endif
                
            </div>
        </div>
    </div>

@endsection

@push('script')
    @stack('script_user_menu')

@endpush