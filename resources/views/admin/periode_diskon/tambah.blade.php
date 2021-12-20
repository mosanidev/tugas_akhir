@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Periode Diskon</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <a href="{{ route('periode_diskon.create') }}" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahPeriodeDiskon">Tambah</a>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Periode Diskon</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama Barang</th>
                        <th>Harga Asli</th>
                        <th>Potongan Harga</th>
                        <th>Harga Jadi</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($periode_diskon as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->nama }}</td>
                          <td>{{ $item->tanggal_dimulai }}</td>
                          <td>{{ $item->tanggal_berakhir }}</td>
                          <td>{{ $item->status }}</td>
                          <td style="width: 20%">
                            <a href="{{ route('periode_diskon.show', ['id' => $item->id]) }}" class="btn btn-info ml-2">Lihat</a>
                            <button class="btn btn-warning ml-2 btn-ubah" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalUbahPeriodeDiskon">Ubah</button>
                            <button type="submit" class="btn btn-danger ml-2 btn-hapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPeriodeDiskon">Hapus</button>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.periode_diskon.modal.confirm_delete')
  @include('admin.periode_diskon.modal.create')
  @include('admin.periode_diskon.modal.edit')

  <p class="d-none" id="notification-message">{{ session('status') }}</p>

  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      if($('#notification-message').html() != "")
      {
        toastr.success($('#notification-message').html())
      }

      
    });
    
  </script>


@endsection