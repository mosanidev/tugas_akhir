@extends('pelanggan.cart.layouts.template')

@section('content')

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

    <a class="btn btn-success text-light float-right">Beli</a>
    
@endsection