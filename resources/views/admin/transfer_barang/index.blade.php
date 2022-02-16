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
                        <td style="width: 10px">{{ sprintf("%04d", $item->id) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format("Y-m-d"); }}</td>
                        <td>{{ $item->lokasi_asal }}</td>
                        <td>{{ $item->lokasi_tujuan }}</td>
                        <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                        <td>
                            <a href="{{ route('transfer_barang.show', ['transfer_barang'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            <button type="button" class="btn btn-warning btnUbah" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modalUbahTransfer"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-hapus-transfer" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-hapus-transfer"><i class="fas fa-trash"></i></button>
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
  @include('admin.transfer_barang.modal.edit_transfer_barang')
  @include('admin.transfer_barang.modal.confirm_ubah') 

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

        $('.btnUbah').on('click', function() {

          const id = $(this).attr('data-id');

          $.ajax({
              type: 'GET',
              url: '/admin/transfer_barang/'+id+'/edit',
              beforeSend: function() {

                  showLoader($('#modalUbahTransferBarang .modal-body'), $('#ubahTransferBarang'));

              },
              success: function(data) 
              {
                  closeLoader($('#modalUbahTransferBarang .modal-body'), $('#ubahTransferBarang'));

                  const transfer_barang = data.transfer_barang;

                  $('#formUbah').attr('action', '/admin/transfer_barang/'+transfer_barang[0].nomor);
                  $('#nomorUbah').val(String(transfer_barang[0].id).padStart(4, '0'));
                  $('#tanggalUbah').val(transfer_barang[0].tanggal);
                  $('#pembuatUbah').val(transfer_barang[0].nama_depan + " " + transfer_barang[0].nama_belakang);
                  $('#lokasiAsalUbah').val(transfer_barang[0].lokasi_asal);
                  $('#lokasiTujuanUbah').val(transfer_barang[0].lokasi_tujuan);
                  $('#keteranganUbah').html(transfer_barang[0].keterangan);
              }
          });

        });

        $('.btnIyaUbah').on('click', function() {

          $('#modalKonfirmasiUbahTransferBarang').modal('toggle');

        });
        

    });

  </script>

@endsection