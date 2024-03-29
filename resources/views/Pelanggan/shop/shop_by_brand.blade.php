@extends('pelanggan.shop.layouts.template')

@section('content-header')

    <div class="pt-5 pb-2">

        @if(count($barang) > 0)
            @if(isset($_GET['key']))
                <a href="{{ route('home') }}" class="d-inline text-secondary">Beranda</a> > <p class="d-inline text-secondary">Pencarian</p> > <p class="d-inline">{{ $_GET['key'] }}</p>
            @else 
                <a href="{{ route('home') }}" class="d-inline text-secondary">Beranda</a> > <a href="{{ route('category', ['id' => $barang[0]->jenis_id] ) }}" class="text-secondary">{{ $barang[0]->nama_jenis }}</a> > <p class="d-inline" id="nama_kategori">{{ $barang[0]->nama_kategori }}</p>
            @endif
        @endif
        
    </div>

@endsection

@section('sidebar')

    <?php 

        $merek_checked = isset($merek_checked) ? $merek_checked : null;

        $hargamin = isset($hargamin) ? $hargamin : "";

        $hargamax = isset($hargamax) ? $hargamax : "";

    ?>

    @if(count($barang) > 0)
    
            @if(isset($_GET['key']))
                <form method="GET" action="{{ route('searchresult.filter.order') }}"> 

                <input type="hidden" value="{{$_GET['key']}}" name="key">
                <input type="hidden" value="{{$_GET['input_kategori']}}" name="input_kategori">
            @else 
                <form method="GET" action="{{ route('filter.order', ['id' => $barang[0]->kategori_id]) }}"> 
            @endif

            <h5>Merek</h5>

            @if(isset($urutkan))
                <input type="hidden" value="{{ $urutkan }}" class="urutkan" name="urutkan">
            @else
                <input type="hidden" value="" class="urutkan" name="urutkan">
            @endif

            <input type="hidden" value="{{ $barang[0]->kategori_id }}" name="kategori_id">
            <div class="form-check">
                @for ($i1 = 0; $i1 < count($merek_barang); $i1++)
                    @if($merek_checked != null)
                        <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i1]->id }}" @if(in_array($merek_barang[$i1]->id, $merek_checked)) checked @endif>
                        <label class="form-check-label">{{ $merek_barang[$i1]->merek_barang }}</label><br>   
                    @else
                        <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i1]->id }}">
                        <label class="form-check-label">{{ $merek_barang[$i1]->merek_barang }}</label><br>
                    @endif
                @endfor
            </div>
            <div class="form-group">
                <h5 class="my-2">Rentang Harga</h5>
                Rp<input type="number" class="form-control d-inline mx-1" min="0" step="100" style="width:41%; font-size: 13px;" name="hargamin" id="formGroupExampleInput" value="{{ $hargamin }}">-<input type="number" min="0" step="100" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamax" id="formGroupExampleInput" value="{{ $hargamax }}">
            </div>
            <button type="submit" class="btn btn-success mt-1" id="btn-terapkan">Terapkan</button>
            
        </form>
        

        @if(isset($_GET['key']))
            <form method="GET" action="{{ route('searchresult.filter.order') }}" class="formUrutkan"> 

            <input type="hidden" value="{{$_GET['key']}}" name="key">
            <input type="hidden" value="{{$_GET['input_kategori']}}" name="input_kategori">
        @else 
            <form method="GET" action="{{ route('filter.order', ['id' => $barang[0]->kategori_id]) }}" class="formUrutkan"> 
        @endif

            <input type="hidden" value="{{ $barang[0]->kategori_id }}" name="kategori_id">

            @if(isset($urutkan))
                <input type="hidden" value="{{ $urutkan }}" class="urutkan" name="urutkan">
            @else
                <input type="hidden" value="" class="urutkan" name="urutkan">
            @endif
    
            @if(isset($_GET['merek']))
                <input type="hidden" name="merek[]" value="{{ implode(" ",$_GET['merek']) }}">
            @endif
            @if(isset($_GET['hargamin']))
                <input type="hidden" name="hargamin" value="{{ $_GET['hargamin'] }}">
            @endif
            @if(isset($_GET['hargamax']))
                <input type="hidden" name="hargamax" value="{{ $_GET['hargamax'] }}">
            @endif
    
        </form>
    @endif

    

@endsection

@section('content-urutkan')

    @if(count($barang) >  0) 
        <div class="col-md-12">
            <p class="text-right">URUTKAN &nbsp; 
                <select class="form-control d-inline" id="selectUrutkan" name="urutkan" style="width: 250px;">
                    <option value="random" @if(isset($urutkan) && $urutkan == 'random') selected @endif>ACAK</option>
                    <option value="a-z" @if(isset($urutkan) && $urutkan == 'a-z') selected @endif>ALFABET A-Z</option>
                    <option value="z-a" @if(isset($urutkan) && $urutkan == 'z-a') selected @endif>ALFABET Z-A</option>
                    <option value="minharga" @if(isset($urutkan) && $urutkan == 'minharga') selected @endif>HARGA TERENDAH</option>
                    <option value="maxharga" @if(isset($urutkan) && $urutkan == 'maxharga') selected @endif>HARGA TERTINGGI</option>
                    <option value="promo" @if(isset($urutkan) && $urutkan == 'promo') selected @endif>PROMO</option>
                </select>
            </p>
        </div>
    @endif

@endsection

@push('content-script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#selectUrutkan').on('change', function() {

                const urutkan = $(this).val();

                $('.urutkan').val(urutkan);
                
                $('.formUrutkan').submit();

            });
            
        });

        

    </script>

@endpush