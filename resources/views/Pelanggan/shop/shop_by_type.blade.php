@extends('pelanggan.shop.layouts.template')

@section('sidebar')
    @for ($i = 0; $i < count($jenis_barang); $i++)
        <a href="{{ route('category', ['id' => $jenis_barang[$i]->id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $jenis_barang[$i]->jenis_barang }}</p></a>
    @endfor
@endsection