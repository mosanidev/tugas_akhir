@extends('pelanggan.shop.layouts.template')

@section('content-header')

    <div class="pt-5 pb-2">
        <a href="{{ route('home') }}" class="d-inline text-secondary" id="beranda">Beranda</a> >
    </div>

@endsection

@section('sidebar')

    @for ($i = 0; $i < count($jenis_barang); $i++)
        <a href="{{ route('category', ['id' => $jenis_barang[$i]->id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $jenis_barang[$i]->jenis_barang }}</p></a>
    @endfor

@endsection

@push('content-script')

    <script type="text/javascript">

        $('#filterUrutkan').val($('#beranda').html());

    </script>

@endpush