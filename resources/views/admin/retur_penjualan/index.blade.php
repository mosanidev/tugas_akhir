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
                          <th>Jenis Retur</th>
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
                              <td>{{ $item->jenis_retur }}</td>
                              <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                              <td>{{ \Carbon\Carbon::parse($item->tanggal_jual)->isoFormat('DD-MM-Y') }}</td>
                              <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->isoFormat('DD-MM-Y') }}</td>
                              <td>{{ $item->status }}</td>
                              <td>
                                <a href="{{ route('retur_penjualan.show', ['retur_penjualan' => $item->id]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                                @if($item->status == "Harap tunggu pengembalian dana dari admin")
                                  <button class="btn btn-info w-100 btnLunasiRefund" data-toggle="modal" data-target="#modalLunasiRefund" data-id="{{ $item->id }}" data-status="{{ $item->status }}">Kembalikan dana</button>
                                @elseif($item->status != "Pengembalian dana telah dilakukan") 
                                  <button class="btn btn-info w-100 btnUbahStatus" data-toggle="modal" data-target="#modalUbahStatus" data-id="{{ $item->id }}" data-jenis-retur="{{ $item->jenis_retur }}" data-status="{{ $item->status }}">Ubah Status</button>
                                @endif
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
@include('admin.retur_penjualan.modal.confirm_ubah')
@include('admin.retur_penjualan.modal.confirm_lunasi')
@include('admin.retur_penjualan.modal.refund')

  <!-- Toastr -->
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
  }
  else if("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
  }

  $('.btnUbahStatus').on('click', function() {

    let id = $(this).attr('data-id');
    let status = $(this).attr('data-status');
    let jenisRetur = $(this).attr('data-jenis-retur');
    // $('#retur_penjualan_id').val(id);

    if(jenisRetur == "Pengembalian dana")
    {
      $('.contentUbahStatus').html(`<select class="form-control select2 select2bs4" name="status_retur" id="selectStatusRetur" required>
                                        <option value="Menunggu pengajuan dicek admin">Menunggu pengajuan dicek admin</option>
                                        <option value="Pengajuan retur diterima admin">{{ "Pengajuan retur diterima admin" }}</option>
                                        <option value="Pengajuan retur ditolak admin">{{ "Pengajuan retur ditolak admin" }}</option>
                                        <option value="Barang retur telah diterima admin">{{ "Barang retur telah diterima admin" }}</option>
                                        <option value="Harap tunggu pengembalian dana dari admin">{{ "Harap tunggu pengembalian dana dari admin" }}</option>
                                    </select>`);
    }
    else 
    {
      $('.contentUbahStatus').html(`<select class="form-control select2 select2bs4" name="status_retur" id="selectStatusRetur" required>
                                        <option value="Menunggu pengajuan dicek admin">Menunggu pengajuan dicek admin</option>
                                        <option value="Pengajuan retur diterima admin">{{ "Pengajuan retur diterima admin" }}</option>
                                        <option value="Pengajuan retur ditolak admin">{{ "Pengajuan retur ditolak admin" }}</option>
                                        <option value="Barang retur telah diterima admin">{{ "Barang retur telah diterima admin" }}</option>
                                        <option value="Harap tunggu produk pengganti sampai ke lokasi tujuan">{{ "Harap tunggu produk pengganti sampai ke lokasi tujuan" }}</option>
                                    </select>`);
    }

    $('#statusReturSebelumnya').val(status);

    $('#formUbahStatus').attr('action', '/admin/retur_penjualan/'+id);

    $('#selectStatusRetur').val(status);

  });

  $('.btnLunasiRefund').on('click', function() {

    const id = $(this).attr('data-id');

    $.ajax({
      type: 'GET',
      url: "/admin/retur_penjualan/tampilkan_nomor_rekening/"+id,
      success: function(data){

        $('input[name=bank]').val(data.rekening_retur[0].bank);
        $('input[name=nama_pemilik_rekening]').val(data.rekening_retur[0].nama_pemilik_rekening);
        $('input[name=nomor_rekening]').val(data.rekening_retur[0].nomor_rekening);
        $('input[name=total_refund]').val(convertAngkaToRupiah(data.rekening_retur[0].total));

      }
    });
    
    $('#formLunasiRefund').attr('action', '/admin/retur_penjualan/lunasi/' + id);

  });

  $('#btnUbahStatusRetur').on('click', function() {

    if($('#statusReturSebelumnya').val() == $('#selectStatusRetur :selected').val())
    {
      $('#modalUbahStatus').modal('toggle');    
    }
    else 
    {
      $('.statusReturLama').html($('#statusReturSebelumnya').val());
      $('.statusReturBaru').html($('#selectStatusRetur :selected').val());
      $('#modalUbahStatus').modal('toggle');
      $('#modalKonfirmasiUbahStatus').modal('toggle');
    }

  });

  $('.btnIyaSubmit').on('click', function() {

    $('#modalKonfirmasiUbahStatus').modal('toggle');
    $('#formUbahStatus').submit();
    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
  
  });

  $('.btnSimpanLunasi').on('click', function(){ 

    if($('input[name=total_refund]').val() == "")
    {
      toastr.error("Harap isi pengembalian dana terlebih dahulu", "Error", toastrOptions);
    }
    else 
    {
      $('#modalLunasiRefund').modal('toggle');
      $('#modalKonfirmasiLunasi').modal('toggle');
    }
    

  });

  $('.btnIyaLunasi').on('click', function() {

    $('#formLunasiRefund').submit();
    $('#modalKonfirmasiLunasi').modal('toggle');
    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

  });

</script>
@endsection