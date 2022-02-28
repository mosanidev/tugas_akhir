@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pembelian</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <a href="{{ route('pembelian.create') }}" class="btn btn-success ml-2">Tambah</a>

    {{-- <div class="my-4">
      <p>Filter : </p>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Rentang Tanggal Buat Nota Pembelian</p> 
        </div>
        <div class="col-9">
          <div class="input-group w-50">
                <input type="text" class="form-control selectFilter" id="rentangTanggalBuat">
                <div class="input-group-append">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
          </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Rentang Tanggal Jatuh Tempo Pelunasan</p> 
        </div>
        <div class="col-9">
          <div class="input-group w-50">
                <input type="text" class="form-control selectFilter" id="rentangTanggalJatuhTempo">
                <div class="input-group-append">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
          </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Status Bayar</p> 
        </div>
        <div class="col-9">
            <select class="form-control w-50 selectFilter" id="statusBayar">
              <option selected>Semua</option>
              <option>Belum lunas</option>
              <option>Sudah lunas</option>
            </select>
        </div>
      </div> --}}

    </div>
    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pembelian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th class="width: 10px;">No Pembelian</th>
                          <th>Nomor Nota dari Pemasok</th>
                          <th>Tanggal Buat</th>
                          <th>Tanggal Jatuh Tempo Pelunasan</th>
                          <th>Pemasok</th>
                          <th>Total</th>
                          <th>Status Bayar</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($pembelian as $item)
                        <tr class="rowPembelian">
                          <td class="width: 10px;">{{ $item->id }}</td>
                          <td>{{ $item->nomor_nota_dari_supplier }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isoFormat('D MMMM Y') }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>
                            {{ $item->status_bayar }}
                          </td>
                          <td>
                            <a href="{{ route('pembelian.show', ['pembelian'=>$item->id]) }}" class='btn btn-secondary w-100 mb-1'>Lunasi</a>
                            <a href="{{ route('pembelian.show', ['pembelian'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                            
                            @if($item->status_retur == "Tidak ada retur" && $item->status_bayar == "Belum lunas" || $item->status_bayar == "Lunas sebagian")
                              <a href="{{ route('pembelian.edit', ['pembelian'=>$item->id]) }}" class='btn btn-warning w-100 mb-1'>Ubah</a>
                              <button class='btn btn-danger btnHapus w-100' data-id="{{ $item->id }}" data-nomor-nota="{{ $item->nomor_nota_dari_supplier }}" data-toggle="modal" data-target="#modalKonfirmasiHapusPembelian">Hapus</button>
                            @endif

                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

@include('admin.pembelian.modal.confirm_delete')
@include('admin.pembelian.modal.info')

@if(session('errors'))
    <script type="text/javascript">
      @foreach ($errors->all() as $error)
          toastr.error("{{ $error }}", "Error", toastrOptions);
      @endforeach
    </script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">

  //Initialize Select2 Elements
  $('#selectSupplier').select2({
      dropdownParent: $("#modalTambahPembelian"),
      theme: 'bootstrap4'
  });

  $('#selectSupplierUbah').select2({
      dropdownParent: $("#modalUbahPembelian"),
      theme: 'bootstrap4'
  });

  $('#datepickerTgl').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
  });

  $('#datepickerTglJatuhTempo').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
  });

  $('#datepickerTglJatuhTempoUbah').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
  });

  $('#datepickerTglUbah').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
  });

  $('#datepickerTglJatuhTempo').on('change', function() {

    let dateNow = moment().format("Y-m-d");

    if($('#datepickerTglJatuhTempo').val() < $('#datepickerTgl').val())
    {
      $('#datepickerTglJatuhTempo').val("");
      toastr.error("Harap tanggal jatuh tempo setelah tanggal buat", "Error", toastrOptions);
    }

  });

  $('#datepickerTglJatuhTempoUbah').on('change', function() {

    if($('#datepickerTglJatuhTempoUbah').val() < $('#datepickerTglUbah').val())
    {
      $('#datepickerTglJatuhTempoUbah').val("");
      toastr.error("Harap tanggal jatuh tempo setelah tanggal buat", "Error", toastrOptions);
    }

  });

  $('#btnTambahPembelian').on('click', function() {

    if($('#inputNomorNota').val() == "")
    {
      toastr.error('Harap isi nomor nota terlebih dahulu', 'Error', toastrOptions);
    }
    else if ($('#datepickerTgl').val() == "")
    {
      toastr.error('Harap pilih tanggal terlebih dahulu', 'Error', toastrOptions);
    }
    else if($('#selectSupplier').val() == null)
    {
      $('#btnTambahPembelian').attr('type', 'button');

      toastr.error('Harap pilih supplier terlebih dahulu', 'Error', toastrOptions);
    }
    else
    {
      $('#btnTambahPembelian').attr('type', 'submit');
      $('#btnTambahPembelian').click();
    }

  });

  $('.btnUbah').on('click', function() {

      let pembelian_id = $(this).attr("data-id");

      $.ajax({
          url: "/admin/pembelian/"+pembelian_id,
          type: 'GET',
          beforeSend: function(data) {
              
          },
          success:function(data) {

            $('#inputNomorNotaUbah').val(data.pembelian[0].nomor_nota);
            $('#datepickerTglUbah').val(data.pembelian[0].tanggal);
            $('#datepickerTglJatuhTempoUbah').val(data.pembelian[0].tanggal_jatuh_tempo);
            $('#selectSupplierUbah').val(data.pembelian[0].supplier_id).change();
            $('#selectMetodePembayaranUbah').val(data.pembelian[0].metode_pembayaran).change();
            $('#inputDiskonUbah').val(data.pembelian[0].diskon);
            $('#inputPPNUbah').val(data.pembelian[0].ppn);
            $('#selectStatusUbah').val(data.pembelian[0].status).change();

            $('#formUbah').attr('action', '/admin/pembelian/'+pembelian_id);

          }

      });

  });

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
  }
  else if ("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
  }

  $('#rentangTanggalBuat').daterangepicker({
      startDate: moment().startOf('days'),
      endDate: moment().startOf('days'),
      locale: {
        format: 'YYYY-MM-DD'
      }
  });

  $('#rentangTanggalJatuhTempo').daterangepicker({
      startDate: moment().startOf('days'),
      endDate: moment().startOf('days'),
      locale: {
        format: 'YYYY-MM-DD'
      }
  });

  $(document).ready(function() {

    let table = $('#dataTable').DataTable({
      "order": [[ 2, 'desc' ], [3, 'desc']]
    });

    // let filter = $('.selectFilter :selected').val();

    // $('.selectFilter').on('change', function() {
    
    //   table.draw();

    // });

    // $.fn.dataTable.ext.search.push(
    //     function( settings, data, dataIndex ) {
    //       filterMetodeTransaksi = $('#selectMetodeTransaksi').val();
    //       filterRentangTanggal = $('#rentangTanggal').val();
    //       filterStatus = $('#selectStatus').val();

    //       let metodeTransaksi = data[3];
    //       let status = data[5];
    //       let tanggal = data[1].replace(" WIB", "");

    //       var showMetodeTransaksi = false;
    //       var showRentangTanggal = false;
    //       var showStatus = false;
          
    //       if (filterMetodeTransaksi == "Semua" || filterStatus.val == "Semua" || filterRentangTanggal == "Selamanya") {
    //         $.fn.dataTable.ext.search.length == 0; 
    //       }

    //       if (filterMetodeTransaksi == "Semua" || filterMetodeTransaksi == metodeTransaksi) {
    //         showMetodeTransaksi = true;
    //       }

    //       if(filterRentangTanggal == "Selamanya" || moment(tanggal).isBetween(filterRentangTanggal.split(" - ")[0], filterRentangTanggal.split(" - ")[1], 'days', '[]') == true)
    //       {
    //         showRentangTanggal = true;
    //       }
          
    //       if(filterStatus == "Semua" || filterStatus == status)
    //       {
    //         showStatus = true;
    //       }

    //       return showMetodeTransaksi && showRentangTanggal && showStatus;
    // });
    
    $(".btnHapus").on('click', function() {

      let id = $(this).attr('data-id');
      let nomorNota = $(this).attr('data-nomor-nota');

      $('.nomorNotaPembelian').html(nomorNota);

      $('#formHapus').attr("action", "/admin/pembelian/"+id);

    });

    $('.btnInfo').on('click', function(){

      let aksi = $(this).attr('data-aksi');
      let nomorNota = $(this).attr('data-nomor-nota'); 

      $('.keterangan').html(aksi);
      $('.nomorNotaKeterangan').html(nomorNota);

    });

  });

</script>
@endsection