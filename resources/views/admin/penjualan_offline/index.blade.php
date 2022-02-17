@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Penjualan Offline</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <a href="{{ route('penjualanoffline.create') }}" class="btn btn-success ml-2">Tambah</a>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Tanggal</th>
                          <th>Metode Pembayaran</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($penjualan as $item)
                        <tr>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm:ss')." WIB" }}</td>
                          <td>{{ $item->metode_pembayaran }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>
                            <a href="{{ route('penjualanoffline.show', ['penjualanoffline'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a> 
                            {{-- <a href="{{ route('penjualanoffline.edit', ['penjualanoffline'=>$item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>  --}}
                            <button class="btn btn-warning btnUbah" data-toggle="modal" data-target="#modalKonfirmasiUbahPenjualanOffline" data-id="{{$item->id}}" data-nomor-nota="{{ $item->nomor_nota }}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btnHapus" data-toggle="modal" data-target="#modalKonfirmasiHapusPenjualanOffline" data-id="{{$item->id}}" data-nomor-nota="{{ $item->nomor_nota }}"><i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@include('admin.penjualan_offline.modal.confirm_hapus')
@include('admin.penjualan_offline.modal.confirm_ubah')

<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Success", toastrOptions);
  }
  else if("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Error", toastrOptions);
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    let nomorNota = $(this).attr('data-nomor-nota');

    $('.penjualanInginDihapus').html(nomorNota);

    $('#formHapus').attr('action', '/admin/penjualanoffline/'+id);

  });

  $('.btnUbah').on('click', function() {

    let id = $(this).attr('data-id');

    $('#formUbah').attr('action', '/admin/penjualanoffline/'+id+'/edit');


  });

  $('.btnIyaUbah').on('click', function() {

    $('#formUbah').submit();

  });

</script>
@endsection