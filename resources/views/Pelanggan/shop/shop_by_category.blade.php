@extends('pelanggan.shop.layouts.template')

@section('sidebar')

    @for ($i = 0; $i < count($kategori_barang); $i++)
        <a href="{{ route('brand', ['id' => $kategori_barang[$i]->kategori_id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $kategori_barang[$i]->kategori_barang }}</p></a>
    @endfor
@endsection