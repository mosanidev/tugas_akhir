@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>Daftar Pembelian Anggota Kopkar</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <p class="mt-2 ml-2">Filter : </p> 
    
  <form action="{{ route('anggota.pembelian.filter') }}" method="GET">
    <div class="row">
      <div class="col-12">
        <p class="mt-2 ml-2">Rentang Waktu</p> 
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="input-group">
          <input type="text" id="filter_tanggal_awal" class="form-control" name="filter_tanggal_awal" placeholder="Tanggal Awal" @if(isset($_GET['filter_tanggal_awal'])) value="{{ $_GET['filter_tanggal_awal']}}" @endif>
          <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <div class="col-1">
        <p class="mt-2 mr-4">sampai</p>
      </div>
      <div class="col-4">
        <div class="input-group float-left">
          <input type="text" id="filter_tanggal_akhir" class="form-control" name="filter_tanggal_akhir" placeholder="Tanggal Akhir" @if(isset($_GET['filter_tanggal_akhir'])) value="{{ $_GET['filter_tanggal_akhir']}}" @endif>
          <div class="input-group-append">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-success h-25 ml-3">Filter</button>
    </div>
  </form>
  
    <hr>

    @if(isset($anggota))
      <div class="card shadow my-4">
          <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Pembelian Anggota</h6>
          </div>
          <div class="card-body">
              <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Nama Anggota</th>
                            <th>Total Pembelian</th>
                          </tr>
                      </thead>
                      <tbody> 
                          @for($i = 0; $i < count($anggota); $i++)
                            @for($x = 0; $x < count($anggotaBeli); $x++)
                              @if($anggota[$i]->nama == $anggotaBeli[$x]->nama)
                                  <tr>
                                      <td>{{ $anggota[$i]->nama }}</td>
                                      <td>{{ "Rp " . number_format($anggotaBeli[$x]->pembelian,0,',','.') }}</td>
                                  </tr>
                              @else 
                                  <tr>
                                      <td>{{ $anggota[$i]->nama }}</td>
                                      <td>{{ "Rp " . number_format(0,0,',','.') }}</td>
                                  </tr>
                              @endif
                            @endfor
                          @endfor
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    @endif
</div>


<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function() {
    
    $('#filter_tanggal_awal').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#filter_tanggal_akhir').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

  });
    
</script>
@endsection