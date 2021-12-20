@extends('pelanggan.order.layouts.template')

@section('content')
 
<div class="p-5 my-5 w-50 mx-auto" style="background-color: #FFF47D" id="content-cart">

    <div class="content">

        @if($penjualan[0]->status == "Pesanan sudah dibayar dan sedang disiapkan")
            <h5 class="text-center"><strong>Terimakasih Sudah Membayar</strong></h5>
        @elseif ($penjualan[0]->status == "Menunggu pesanan dibayarkan")
            <h5 class="text-center"><strong>Menunggu Pembayaran</strong></h5>
        @endif

        <br>

        @if($penjualan[0]->metode_pembayaran == "bank_transfer")
            <div class="row">
                <div class="col-6">
                    <p>Metode Pembayaran</p>
                    <p>Nomor Rekening</p>
                    <p>Sebesar</p>
                    @if($penjualan[0]->status == "Menunggu Pembayaran") <p>Sebelum</p> @endif
                </div>
                <div class="col-6">
                    <p>{{ $penjualan[0]->metode_pembayaran}}</p>
                    <p>{{ $penjualan[0]->nomor_rekening }}</p>
                    <p>{{ "Rp " . number_format($penjualan[0]->total,0,',','.') }}</p>
                    @if($penjualan[0]->status == "Menunggu Pembayaran") <p> {{ \Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('D MMMM Y').", Pukul ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('HH:mm'); }} </p> @endif
                    
                </div>
            </div>
        @else 
            <div class="row">
                <div class="col-6">
                    <p>Metode Pembayaran</p>
                    <p>Total Harga</p>
                </div>
                <div class="col-6">
                    <p>{{ $penjualan[0]->metode_pembayaran}}</p>
                    <p>{{ "Rp " . number_format($penjualan[0]->total,0,',','.') }}</p>
                </div>
            </div>
        @endif
        <a href="{{ route('order') }}" class="btn btn-link float-left">Lihat Detail Pesanan</a>
        <a href="{{ route('home') }}" class="btn btn-link float-right">Kembali ke Beranda</a>
    </div>
    
</div>


@endsection