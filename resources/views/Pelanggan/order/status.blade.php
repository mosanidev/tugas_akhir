@extends('pelanggan.order.layouts.template')

@section('content')
 
<div class="p-5 my-5 w-50 mx-auto" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

    <div class="content">

        @if($status->payment_type == "bank_transfer")
            <div class="row">
                <div class="col-7">
                    <p>Metode Pembayaran</p>
                    <p>Nomor Tujuan</p>
                    <p>Total Harga</p>
                    <p>Batasan Waktu Pembayaran</p>
                </div>
                <div class="col-5">
                    <p>{{ $status->payment_type}}</p>
                    <p>{{ $status->va_numbers[0]->va_number }}</p>
                    <p>{{ "Rp " . number_format($status->gross_amount,0,',','.') }}</p>
                    <p>{{ $status->transaction_time }}</p>
                </div>
            </div>
        @else 
            <div class="row">
                <div class="col-7">
                    <p>Metode Pembayaran</p>
                    <p>Total Harga</p>
                </div>
                <div class="col-5">
                    <p>{{ $status->payment_type}}</p>
                    <p>{{ "Rp " . number_format($status->gross_amount,0,',','.') }}</p>
                </div>
            </div>
        @endif
        <a href="{{ route('order') }}" class="btn btn-link float-left">Lihat Detail Pesanan</a>
        <a href="{{ route('home') }}" class="btn btn-link float-right">Kembali ke Beranda</a>
    </div>
    
</div>


@endsection