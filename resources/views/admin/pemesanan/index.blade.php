@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pemesanan</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <a href="{{ route('pemesanan.create') }}" class="btn btn-success ml-2">Tambah</a>

    {{-- <div class="my-4">
      <p>Filter : </p>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Status Bayar</p> 
        </div>
        <div class="col-9">
            <select class="form-control w-50 selectFilter">
              <option selected>Semua</option>
              <option>Belum Lunas</option>
              <option>Sudah Lunas</option>
            </select>
        </div>
      </div>

    </div> --}}

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pemesanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Tanggal Pemesanan</th>
                          <th>Pemasok</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($pemesanan as $item)
                        <tr class="rowPembelian">
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ "Rp " . number_format($item->total-$item->diskon-$item->ppn ,0,',','.') }}</td>
                          <td>{{ $item->status }}</td>
                          <td>

                            <a href="{{ route('pemesanan.show', ['pemesanan'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            
                            @if($item->status != "Telah diterima di gudang")
                              <a href="{{ route('pemesanan.edit', ['pemesanan'=>$item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>
                              <button class='btn btn-danger btnHapus' data-id="{{ $item->id }}" data-nomor-nota="{{ $item->nomor_nota }}" data-toggle="modal" data-target="#modalKonfirmasiHapusPemesanan"><i class="fas fa-trash"></i></button>
                            @endif
                            
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

@include('admin.pemesanan.modal.confirm_delete')
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

  $('.btnHapus').on('click', function() {

    let nomorNota = $(this).attr('data-nomor-nota');
    let id = $(this).attr('data-id');

    $('.nomorNotaHapus').html(nomorNota);

    $('#formHapus').attr('action', '/admin/pemesanan/'+id);

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

  $(document).ready(function() {

    let table = $('#dataTable').DataTable({});

    let filter = $('.selectFilter :selected').val();

    $('.selectFilter').on('click', function() {
    
      console.log($('.selectFilter :selected').val());
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

    
    $(".btnHapus").on('click', function() {

      let id = $(this).attr('data-id');
      let nomorNota = $(this).attr('data-nomor-nota');

      $('.nomorNotaPembelian').html(nomorNota);

      $('#formHapus').attr("action", "/admin/pemesanan/"+id);

    });

    $(".btnIyaHapus").on('click', function() {

      $('#formHapus').submit();

      $('#modalKonfirmasiHapusPemesanan').modal('toggle');

      $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

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