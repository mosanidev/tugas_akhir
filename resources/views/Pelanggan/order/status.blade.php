@extends('pelanggan.order.layouts.template')

@section('content')
 
<div class="p-5 my-5 w-50 mx-auto" style="background-color: #FFF47D" id="content-cart">

    <div class="content">

        @if($penjualan[0]->status == "Pesanan sudah dibayar dan sedang disiapkan")
            <h5 class="text-center"><strong>Terimakasih Sudah Membayar<br>Kami sedang mempersiapkan pesanan anda</strong></h5>
            {{-- <p class="text-center">Kami sedang mempersiapkan pesanan anda</p> --}}
        @elseif ($penjualan[0]->status == "Menunggu pesanan dibayarkan")
            <h5 class="text-center"><strong>Menunggu Pembayaran</strong></h5>
        @else 
            <h5 class="text-center"><strong>{{$penjualan[0]->status}}</strong></h5>
        @endif

        <br>

        @if($penjualan[0]->metode_pembayaran == "bank_transfer" || $penjualan[0]->metode_pembayaran == "credit_card")
            <div class="row">
                <div class="col-6">
                    <p>Metode Pembayaran</p>
                </div>
                <div class="col-6">
                    @if($penjualan[0]->metode_pembayaran == "bank_transfer")
                        <p>{{ "Transfer Bank ".strtoupper($penjualan[0]->bank) }}</p>
                    @elseif($penjualan[0]->metode_pembayaran == "credit_card")
                        <p>{{ "Kredit" }}</p>
                    @endif
                </div>
                <div class="col-6">
                    <p>Nomor Rekening</p> 
                </div>
                <div class="col-6">
                    <p>{{ $penjualan[0]->nomor_rekening }}</p>
                </div>
                <div class="col-6">
                    <p>Sebesar</p>
                </div>
                <div class="col-6">
                    <p>{{ "Rp " . number_format($penjualan[0]->total,0,',','.') }}</p>
                </div>
                <div class="col-6">
                    @if($penjualan[0]->status == "Menunggu pesanan dibayarkan") 
                        <p>Sebelum</p> 
                    @elseif($penjualan[0]->status == "Pesanan sudah dibayar dan sedang disiapkan")
                        <p>Waktu Pelunasan</p>    
                    @endif
                </div>
                <div class="col-6">
                    @if($penjualan[0]->status == "Menunggu pesanan dibayarkan") 
                        <p> {{ \Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('D MMMM Y').", Pukul ".\Carbon\Carbon::parse($penjualan[0]->batasan_waktu)->isoFormat('HH:mm')." WIB"; }} </p> 
                    @elseif($penjualan[0]->status == "Pesanan sudah dibayar dan sedang disiapkan")
                        <p> {{ \Carbon\Carbon::parse($penjualan[0]->waktu_lunas)->isoFormat('D MMMM Y').", Pukul ".\Carbon\Carbon::parse($penjualan[0]->waktu_lunas)->isoFormat('HH:mm'); }} </p>    
                    @endif
                </div>
                {{-- <div class="col-6">
                    @if($penjualan[0]->metode_transaksi == "Ambil di toko")
                        <p>Batasan Waktu Pengambilan</p> 
                    @endif
                </div>
                <div class="col-6">
                    @if($penjualan[0]->metode_transaksi == "Ambil di toko")
                        <p> {{ \Carbon\Carbon::parse($penjualan[0]->batasan_waktu_pengambilan)->isoFormat('D MMMM Y').", Pukul ".\Carbon\Carbon::parse($penjualan[0]->waktu_lunas)->isoFormat('HH:mm'); }} </p>    
                    @endif
                </div> --}}
            </div>
        @else 
            <div class="row">
                <div class="col-6">
                    <p>Metode Pembayaran</p>
                    <p>Sebesar</p>
                </div>
                <div class="col-6">
                    <p>{{ "E-Wallet" }}</p>
                    <p>{{ "Rp " . number_format($penjualan[0]->total,0,',','.') }}</p>
                </div>
            </div>
        @endif
        <a href="{{ route('order') }}" class="btn btn-link float-left">Lihat Detail Pesanan</a>
        <a href="{{ route('home') }}" class="btn btn-link float-right">Kembali ke Beranda</a>
    </div>
    
</div>


@endsection