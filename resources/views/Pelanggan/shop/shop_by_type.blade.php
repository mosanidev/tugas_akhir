@extends('pelanggan.shop.layouts.template')

@section('content-header')

    @if(count($barang) > 0)
        <div class="pt-5 pb-2">
            <a href="{{ route('home') }}" class="d-inline text-secondary" id="beranda">Beranda</a> >
        </div>
    @endif

@endsection

@section('sidebar')

    @for ($i = 0; $i < count($jenis_barang); $i++)
        <a href="{{ route('category', ['id' => $jenis_barang[$i]->id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $jenis_barang[$i]->jenis_barang }}</p></a>
    @endfor

@endsection

@section('content-urutkan')

    @if(count($barang) > 0)
        <div class="col-md-12">
            <form method="GET" action="{{ route('order.products') }}" id="formUrutkan">
                <p class="text-right">URUTKAN &nbsp; 
                    <select class="form-control d-inline" id="selectUrutkan" name="urutkan" style="width: 200px;">
                        <option value="random" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'a-z') selected @endif>ACAK</option>
                        <option value="a-z" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'a-z') selected @endif>ALFABET A-Z</option>
                        <option value="z-a" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'z-a') selected @endif>ALFABET Z-A</option>
                        <option value="minharga" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'minharga') selected @endif>HARGA TERENDAH</option>
                        <option value="maxharga" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'maxharga') selected @endif>HARGA TERTINGGI</option>
                        <option value="promo" @if(isset($_GET['urutkan']) && $_GET['urutkan'] == 'promo') selected @endif>PROMO</option>
                    </select>
                </p>
            </form>
        </div>
    @endif

@endsection

@push('content-script')

    <script type="text/javascript">


        $('#selectUrutkan').on('change', function() {

            $('#formUrutkan').submit();

        });

    </script>

@endpush