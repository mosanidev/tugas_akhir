@extends('pelanggan.order.layouts.template')

@section('content')

<div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

    <h3 class="mb-4"><strong>Pilih Metode Transaksi</strong></h3>

    <div class="row">
        <div class="col-md-4">
            <h5>Metode Transaksi</h5> 

            <a href="{{ route('order_shipment') }}" class="btn btn-outline-success">Kirim ke Alamat</a>
            <a href="{{ route('pickInStore') }}" class="btn btn-outline-success">Ambil di Toko</a>
            

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
        </div>
    </div>
</div>

@endsection