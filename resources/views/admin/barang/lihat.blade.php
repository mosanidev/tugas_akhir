@extends('admin.layouts.master')

@section('content')


    <div class="bg-light">
        <div class="row">

            <div class="col-4">
                <img src="{{ asset($barang[0]->foto) }}" width="300" height="250">
            </div>
    
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <h5><strong>{{$barang[0]->nama}}</strong></h5>
                    </div>
                    <div class="col-4">
                        Jenis
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->jenis }}
                    </div>
                    <div class="col-4">
                        Kategori
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->kategori }}
                    </div>
                    <div class="col-4">
                        Merek
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->merek }}
                    </div>
                    <div class="col-4">
                        Kode
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->kode }}
                    </div> 
                    <div class="col-4">
                        Deskripsi
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->deskripsi }}
                    </div>  
                    <div class="col-4">
                        Harga Jual
                    </div>  
                    <div class="col-8">
                        @if ($barang[0]->diskon_potongan_harga > 0)
                            <del class="mr-1">{{ "Rp " . number_format($barang[0]->harga_jual,0,',','.') }}</del>
                        @endif
                        {{ "Rp " . number_format($barang[0]->harga_jual-$barang[0]->diskon_potongan_harga,0,',','.') }}
                    </div>  
                    <div class="col-4">
                        Diskon Potongan Harga
                    </div>  
                    <div class="col-8">
                        {{ "Rp " . number_format($barang[0]->diskon_potongan_harga,0,',','.') }}
                    </div> 
                    <div class="col-4">
                        Berat
                    </div>  
                    <div class="col-8">
                        {{ $barang[0]->berat. " gram" }}
                    </div> 
                    
                </div>
            </div>
    
        </div>
    </div>
    

    


@endsection