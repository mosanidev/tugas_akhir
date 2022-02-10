@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Retur Penjualan</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    {{-- <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahRetur" data-dismiss="#modalTambahRetur" id="btnTambahRetur">Tambah</button> --}}

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Retur Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota Penjualan</th>
                          <th>Pelanggan</th>
                          <th>Tanggal Jual</th>
                          <th>Tanggal Retur</th>
                          <th>Status Retur</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(isset($retur_penjualan))
                       @if(count($retur_penjualan))
                          @foreach($retur_penjualan as $item)
                            <tr>
                              <td>{{ $item->nomor_nota }}</td>
                              <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                              <td>{{ \Carbon\Carbon::parse($item->tanggal_jual)->isoFormat('D MMMM Y') }}</td>
                              <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->isoFormat('D MMMM Y') }}</td>
                              <td>{{ $item->status }}</td>
                              <td>
                                <a href="#lihat" class='btn btn-info w-100 mb-2'>Lihat</a>
                                <button class="btn btn-info w-100" data-toggle="modal" data-target="#modalUbahStatus" data-id="{{ $item->id }}" id="btnUbahStatus">Ubah Status</button>
                            </td>
                            </tr>
                          @endforeach
                        @endif
                      @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.retur_penjualan.modal.ubah_status')

  <!-- Toastr -->
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}");
  }
  else if("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}");
  }

  $('#btnUbahStatus').on('click', function() {

    let id = $(this).attr('data-id');

    // $('#retur_penjualan_id').val(id);

    $('#formUbahStatus').attr('action', '/admin/retur_penjualan/'+id);

  });

  $('#btnUbahStatusRetur').on('click', function() {

    $('#modalUbahStatus').modal('toggle');
    
    $('#modalKonfirmasiUbahStatus').modal('toggle');

  });

  $('.btnIyaSubmit').on('click', function() {

    $('#formUbahStatus').submit();

    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');


  });

</script>
@endsection