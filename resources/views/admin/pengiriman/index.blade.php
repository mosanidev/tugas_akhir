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
          <p class="mt-2 ml-2">Status Pengiriman</p> 
        </div>
        <div class="col-9">
            <select class="form-control w-50 selectFilter">
              <option selected>Semua</option>
              <option>Pesanan sedang disiapkan untuk diserahkan ke pengirim</option>
              <option>Pesanan sudah diserahkan ke pihak pengirim</option> 
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
                          <th>Nomor Nota Penjualan</th>
                          <th>Tanggal Penjualan</th>
                          <th>Nomor Resi</th>
                          <th>Status Pengiriman</th>
                          <th>Tarif Pengiriman</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(count($pengiriman) > 0)
                        @foreach($pengiriman as $item)
                          <tr>
                            <td>{{ $item->nomor_nota }}</td>
                            <td>{{ $item->tanggal_penjualan }}</td>
                            <td>@if($item->nomor_resi == null) {{ "-" }} @else {{ $item->nomor_resi }} @endif</td>
                            <td> {{ $item->status_pengiriman }} </td>
                            <td>{{ "Rp " . number_format($item->tarif_pengiriman,0,',','.') }}</td>
                            <td>
                                <a href="{{ route('pengiriman.show', ['pengiriman' => $item->pengiriman_id]) }}" class="btn btn-success w-100 mb-2">Lihat</a>

                                @if($item->status_pengiriman == "Pesanan sedang disiapkan untuk diserahkan ke pengirim")

                                  <button type="button" class="btn btn-warning btnProsesKirim w-100" data-toggle="modal" data-target="#modalProsesKirim" data-id="{{$item->pengiriman_id}}">Proses Kirim</button>
                                
                                @else

                                  <button type="button" class="btn btn-warning btnUbahProsesKirim w-100" data-toggle="modal" data-target="#modalUbahProsesKirim" data-id="{{$item->pengiriman_id}}">Ubah</button>
                                  
                                  {{-- <button type="button" class="btn btn-danger btnResetProsesKirim" data-toggle="modal" data-target="#modalConfirmReset" data-id="{{$item->pengiriman_id}}">Reset</button> --}}

                                @endif
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

@include('admin.pengiriman.modal.confirm_proses_kirim')
@include('admin.pengiriman.modal.confirm_reset_proses_kirim')
@include('admin.pengiriman.modal.confirm_ubah_proses_kirim')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

  $('.btnProsesKirim').on('click', function() {

    let pengiriman_id = $(this).attr('data-id');
        
    $.ajax({
        url: "/admin/pengiriman/"+pengiriman_id,
        type: 'GET',
        beforeSend: function() {
          
        },
        success:function(data) {

          let pengiriman = data.pengiriman[0];

          $('.nomor_resi').val(pengiriman.nomor_resi);
          $('input[name=estimasi_tiba]').val(pengiriman.estimasi_tiba);
          $('.tanggal_diserahkan_ke_pengirim').val(moment().format("Y-MM-D H:m:s"));
          $('input[name=shipper]').val(pengiriman.nama_shipper);
          $('input[name=jenis_pengiriman]').val(pengiriman.jenis_pengiriman);
          $('input[name=kota_kabupaten]').val(pengiriman.kota_kabupaten + ", " + pengiriman.provinsi);
          $('input[name=tarif_pengiriman]').val(convertAngkaToRupiah(pengiriman.tarif_pengiriman));
          $('textarea[name=alamat]').html(pengiriman.alamat + ", " + pengiriman.kecamatan + ", " + pengiriman.kota_kabupaten + ", " + pengiriman.provinsi + ", " + pengiriman.kode_pos);
          $('#btnSimpan').attr('data-id', pengiriman.pengiriman_id);
          $('input[name=status]').val(pengiriman.status)
        }
    });

  });

  // $('.btnResetProsesKirim').on('click', function() {

  //   let pengiriman_id = $(this).attr('data-id');

  //   $('#formResetPengiriman').attr('action', '/admin/pengiriman/'+pengiriman_id);

  // });

  $('.btnUbahProsesKirim').on('click', function() {

    let pengiriman_id = $(this).attr('data-id');
        
    $.ajax({
        url: "/admin/pengiriman/"+pengiriman_id,
        type: 'GET',
        beforeSend: function() {
          
        },
        success:function(data) {

          let pengiriman = data.pengiriman[0];

          $('.ubah_nomor_resi').val(pengiriman.nomor_resi);
          $('input[name=estimasi_tiba]').val(pengiriman.estimasi_tiba);
          $('.ubah_tanggal_diserahkan_ke_pengirim').val(pengiriman.tanggal_diserahkan_ke_pengirim);
          $('input[name=shipper]').val(pengiriman.nama_shipper);
          $('input[name=jenis_pengiriman]').val(pengiriman.jenis_pengiriman);
          $('input[name=kota_kabupaten]').val(pengiriman.kota_kabupaten + ", " + pengiriman.provinsi);
          $('input[name=tarif_pengiriman]').val(convertAngkaToRupiah(pengiriman.tarif_pengiriman));
          $('textarea[name=alamat]').html(pengiriman.alamat + ", " + pengiriman.kecamatan + ", " + pengiriman.kota_kabupaten + ", " + pengiriman.provinsi + ", " + pengiriman.kode_pos);
          $('#btnUbah').attr('data-id', pengiriman.pengiriman_id);
          $('input[name=status]').val(pengiriman.status)
        }
    });
  });

  $('#btnSimpan').on('click', function() {

    let pengiriman_id = $(this).attr('data-id');
    let tglDiserahkan = $('.tanggal_diserahkan_ke_pengirim').val();
    let nomor_resi =  $('.nomor_resi').val();

    if(tglDiserahkan == "")
    {
      toastr.error("Mohon isi tanggal diserahkan ke pengirim terlebih dahulu", "Error", toastrOptions);
    }
    else if (nomor_resi == "")
    {
      toastr.error("Mohon isi nomor resi terlebih dahulu", "Error", toastrOptions);
    }
    else 
    {
      $('#modalProsesKirim').modal('toggle');
      $('#modalKonfirmasiProsesKirim').modal('toggle');
      $('input[name=pengiriman_id]').val(pengiriman_id);
      $('input[name=nomor_resi]').val(nomor_resi);
      $('input[name=tanggal_diserahkan_ke_pengirim]').val(tglDiserahkan);
      $('input[name=status_pengiriman]').val("Pesanan sudah diserahkan ke pihak pengirim");

      $('#formKonfirmasiProsesKirim').attr('action', '/admin/pengiriman/'+pengiriman_id)
    }
  });

  jQuery.datetimepicker.setLocale('id');

  $('input[name=tanggal_diserahkan_ke_pengirim]').datetimepicker({
      timepicker: true,
      datepicker: true,
      lang: 'id',
      format: 'Y-m-d H:i:s'
  });

  $('#btnUbah').on('click', function() {

    let pengiriman_id = $(this).attr('data-id');
    let tglDiserahkan = $('.ubah_tanggal_diserahkan_ke_pengirim').val();
    let nomor_resi =  $('.ubah_nomor_resi').val();

    if(tglDiserahkan == "")
    {
      toastr.error("Mohon isi tanggal diserahkan ke pengirim terlebih dahulu", "Error", toastrOptions);
    }
    else if (nomor_resi == "")
    {
      toastr.error("Mohon isi nomor resi terlebih dahulu", "Error", toastrOptions);
    }
    else 
    {
      $('#modalUbahProsesKirim').modal('toggle');
      $('#modalKonfirmasiUbahProsesKirim').modal('toggle');
      $('input[name=pengiriman_id]').val(pengiriman_id);
      $('input[name=nomor_resi]').val(nomor_resi);
      $('input[name=tanggal_diserahkan_ke_pengirim]').val(tglDiserahkan);
      $('input[name=status_pengiriman]').val("Pesanan sudah diserahkan ke pihak pengirim");

      $('#formKonfirmasiUbahProsesKirim').attr('action', '/admin/pengiriman/'+pengiriman_id)
    }

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
    toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
  }
  else if ("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
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