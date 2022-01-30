@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>Daftar Pengiriman Penjualan</h1>
      </div>
  </div>
</section>

<div class="container-fluid">

    <div class="my-4">
      <p>Filter : </p>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Status</p> 
        </div>
        <div class="col-9">
            <select class="form-control w-50 selectFilter">
              <option selected>Semua</option>
              <option>Draft</option>
              <option>Complete</option>
            </select>
        </div>
      </div>

    </div>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Status</th>
                          <th>Nomor Nota</th>
                          <th>Tanggal Penjualan</th>
                          <th>Nomor Resi</th>
                          <th>Metode Transaksi</th>
                          <th>Status Pesanan</th>
                          <th>Status Pengiriman</th>
                          <th>Tarif Pengiriman</th>
                          <th>Aksi</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($penjualan) > 0)
                        @foreach($penjualan as $item)
                          <tr>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->nomor_nota }}</td>
                            <td>{{ $item->tanggal_jual }}</td>
                            <td>@if($item->nomor_resi == null) {{ "-" }} @else {{ $item->nomor_resi }} @endif</td>
                            <td>{{ $item->metode_transaksi }}</td>
                            <td>{{ $item->status }}</td>
                            <td>@if($item->status_pengiriman == null) {{ "-" }} @else {{ $item->status_pengiriman }} @endif</td>
                            <td>{{ "Rp " . number_format($item->tarif_pengiriman,0,',','.') }}</td>
                            <td>
                                @if($item->status_pengiriman == null)
                                  <button type="button" class="btn btn-info btnPanggilKurir" data-toggle="modal" data-target="#modalTambahPengiriman" data-pelanggan="{{ $item->pelanggan_id }}" data-penjualan="{{ $item->penjualan_id }}" data-pengiriman="{{ $item->pengiriman_id }}" data-alamat="{{ $item->alamat_pengiriman_id }}">Panggil kurir</button>
                                @else
                                  <button type="button" class="btn btn-warning mb-2 btnUbahPanggilKurir" data-toggle="modal" data-target="#modalUbahPengiriman" data-id="{{ $item->pengiriman_id }}" data-id-pengiriman="{{ $item->id_pengiriman }}" data-waktu-jemput="{{ $item->waktu_jemput }}" @if($item->status == "Complete") checked disabled  @endif>Ubah penjemputan</button>
                                  <button type="button" class="btn btn-danger btnBatalPanggilKurir" data-toggle="modal" data-target="#modalBatalPengiriman" data-id-pengiriman="{{ $item->id_pengiriman }}" data-id="{{ $item->pengiriman_id }}" @if($item->status == "Complete") checked disabled  @endif>Batal panggil kurir</button>
                                @endif
                            </td>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input checkComplete" type="checkbox" value="" data-id-pengiriman="{{ $item->nomor_nota }}" data-id="{{ $item->pengiriman_id }}" @if($item->status == "Complete") checked disabled @elseif($item->status_pengiriman == null) disabled @endif>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.pengiriman.modal.create')
@include('admin.pengiriman.modal.edit')
@include('admin.pengiriman.modal.confirm_cancel')
@include('admin.pengiriman.modal.confirm_complete')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  $('.btnPanggilKurir').on('click', function() {

    let pengiriman_id = $(this).attr('data-pengiriman');
    let pelanggan_id = $(this).attr('data-pelanggan');
    let penjualan_id = $(this).attr('data-penjualan');
    let alamat_pengiriman_id = $(this).attr('data-alamat');

    $('input[name=pengiriman_id]').val(pengiriman_id);
    $('input[name=pelanggan_id]').val(pelanggan_id);
    $('input[name=penjualan_id]').val(penjualan_id);
    $('input[name=alamat_pengiriman_id]').val(alamat_pengiriman_id);

  });

  $('.btnUbahPanggilKurir').on('click', function() {

    let id = $(this).attr('data-id');
    let id_pengiriman = $(this).attr('data-id-pengiriman');
    let waktu_jemput = $(this).attr('data-waktu-jemput');

    $('input[name=id_pengiriman]').val(id_pengiriman);
    $('#waktuJemputUbah').val(waktu_jemput);

    $('#formUbahPengiriman').attr('action', '/admin/pengiriman/'+id);

  });

  $('.btnBatalPanggilKurir').on('click', function() {
    
    let id = $(this).attr('data-id');
    let id_pengiriman = $(this).attr('data-id-pengiriman');

    $('#formBatalPengiriman').attr('action', '/admin/pengiriman/'+id);
    $('input[name=id_pengiriman]').val(id_pengiriman);
    $('#idPengirimanCancel').html(id_pengiriman);

  });

  $('.checkComplete').on('change', function() {

    let id = $(this).attr('data-id');
    let id_pengiriman = $(this).attr('data-id-pengiriman');

    $('#formKonfirmasi').attr('action', '/admin/pengiriman/konfirmasi/'+id)
    $('input[name=id_pengiriman]').val(id_pengiriman);

    $('#idPengirimanConfirm').html(id_pengiriman);

    $('#modalKonfirmasiComplete').modal('toggle');

  });

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Success", toastrOptions);
  }
  else if ("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Error", toastrOptions);
  }

  $(document).ready(function() {

    let table = $('#dataTable').DataTable({});

    let filter = $('.selectFilter :selected').val();

    $('.selectFilter').on('click', function() {
    
      filterByStatus();

    });

    function filterByStatus() 
    { 
      $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

              filter = $('.selectFilter :selected').val();

              var showFilter = false;

              let dataFiltered = data[0];
              
              $.fn.dataTable.ext.search.length == 0; 
              
              if (filter == "Semua" || filter == "Draft" && dataFiltered == 'Draft') 
              {
                showFilter = true;
              }

              if (filter == "Semua" || filter == "Complete" && dataFiltered == 'Complete') 
              {
                showFilter = true;
              }

              return showFilter;

        });

        table.draw();
    }

  });


</script>
@endsection