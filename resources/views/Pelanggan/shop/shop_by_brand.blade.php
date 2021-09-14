@extends('pelanggan.shop.layouts.template')

@section('sidebar')

    <?php 

        $merek_checked = isset($merek_checked) ? $merek_checked : null;

        $hargamin = isset($hargamin) ? $hargamin : "";

        $hargamax = isset($hargamax) ? $hargamax : "";

    ?>

    <form method="GET" action="{{ route('filter') }}"> 
        <h5>Merek</h5>
        <input type="hidden" value="{{ $id }}" name="kategori_id">
        <div class="form-check">
            @for ($i1 = 0; $i1 < count($merek_barang); $i1++)
                @if($merek_checked != null)
                    <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i1]->merek_id }}" @if(in_array($merek_barang[$i1]->merek_id, $merek_checked)) checked @endif>
                    <label class="form-check-label">{{ $merek_barang[$i1]->merek_barang }}</label><br>   
                @else
                    <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i1]->merek_id }}">
                    <label class="form-check-label">{{ $merek_barang[$i1]->merek_barang }}</label><br>
                @endif
            @endfor

        </div>
        <div class="form-group">
            <h5 class="my-2">Rentang Harga</h5>
            Rp<input type="number" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamin" id="formGroupExampleInput" value="{{ $hargamin }}">-<input type="text" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamax" id="formGroupExampleInput" value="{{ $hargamax }}">
        </div>
        <button type="submit" class="btn btn-success mt-1" id="btn-terapkan">Terapkan</button>
    </form>

@endsection