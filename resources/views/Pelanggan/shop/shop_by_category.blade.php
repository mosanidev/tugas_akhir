@extends('pelanggan.shop.layouts.template')

@section('content-header')

    <div class="pt-5 pb-2">
        <a href="{{ route('home') }}" class="d-inline text-secondary">Beranda</a> > <p class="d-inline" id="nama_jenis">{{ $barang[0]->nama_jenis }}</p> 
    </div>

@endsection

@section('sidebar')

    @for ($i = 0; $i < count($kategori_barang); $i++)
        <a href="{{ route('brand', ['id' => $kategori_barang[$i]->kategori_id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $kategori_barang[$i]->kategori_barang }}</p></a>
    @endfor

@endsection

@push('content-script')

    <script type="text/javascript">

        const jenis_id = "{{ $barang[0]->jenis_id }}";

        $('#formUrutkan').attr("action", "/id/category/" + jenis_id + "/urutkan");

        $('#filterUrutkan').val($('#nama_jenis').html());
        
        $('#jenisFilter').val("jenis_barang");

    </script>

@endpush