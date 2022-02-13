@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Transfer Barang</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>

<div class="container-fluid">

  {{-- <a href="{{ route('transfer_barang.create') }}" class="btn btn-success ml-2 mb-3">Tambah</a> --}}
  
  <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahTransfer">Tambah</button>

  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Supplier</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: 10px">No Transfer</th>
                      <th>Tanggal</th>
                      <th>Lokasi Asal</th>
                      <th>Lokasi Tujuan</th>
                      <th>Pembuat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($transfer_barang as $item)
                      <tr>
                        <td style="width: 10px">{{ $item->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format("Y-m-d"); }}</td>
                        <td>{{ $item->lokasi_asal }}</td>
                        <td>{{ $item->lokasi_tujuan }}</td>
                        <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                        <td>

                            {{-- <button type="button" class="btn btn-warning ml-2 d-inline btn-ubah" id="btn-ubah-{{ $item->id }}" data-toggle="modal" data-target="#modalUbahSupplier">Ubah</button>
                            <button type="button" class='btn btn-danger ml-2 d-inline delete-supplier' data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-hapus-supplier">Hapus</button> --}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.transfer_barang.modal.create_transfer_barang') 

  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  {{-- <script  src=//code.jquery.com/jquery-3.5.1.slim.min.js integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin=anonymous></script> --}}
  <script type="text/javascript">

    $(document).ready(function(){

        $('#datepickerTgl').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        

    });

  </script>

@endsection