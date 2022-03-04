@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>Daftar Anggota Kopkar</h1>
      </div>
  </div>
</section>
<div class="container-fluid">


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
                            <th>No</th>
                            <th>Nomor Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Telepon</th>
                          </tr>
                      </thead>
                      <tbody> 
                          @php $no = 1; @endphp
                          @for($i = 0; $i < count($anggota); $i++)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{$anggota[0]->nomor_anggota }}</td>
                                <td>{{$anggota[0]->nama_depan." ".$anggota[0]->nama_belakang }}</td>
                                <td>{{$anggota[0]->jenis_kelamin }}</td>
                                <td>{{$anggota[0]->nomor_telepon }}</td>
                            </tr>

                            @php $no++ @endphp
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
      format: 'dd-mm-yyyy',
      autoclose: true
    });

    $('#filter_tanggal_akhir').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });

    $('#dataTable').datepicker({
      dom: 'Bfrtip'
    });

  });
    
</script>
@endsection