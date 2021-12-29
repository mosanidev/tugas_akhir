@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Karyawan</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <button type="button" data-toggle="modal" data-target="#modal-tambah-karyawan" class="btn btn-success ml-2 mb-3">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Karyawan</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($karyawan as $item)
                      <tr>
                        <td style="width: 10px">{{ $num++ }}</td>
                        <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
                        <td>{{ $item->nomor_telepon }}</td>
                        <td>
                            <a href="{{ route('karyawan.show', ['karyawan'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            <a href="{{ route('karyawan.edit', ['karyawan' => $item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-hapus-barang" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-hapus-barang"><i class="fas fa-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.karyawan.modal.create')
  @include('admin.karyawan.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      

    });

  </script>


@endsection