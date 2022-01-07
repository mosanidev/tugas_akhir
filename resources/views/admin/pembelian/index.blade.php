@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pembelian</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahPembelian">Tambah</button>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pembelian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th style="width: 10px">No</th>
                          <th>Nomor Nota</th>
                          <th>Tanggal Buat</th>
                          <th>Tanggal Jatuh Tempo</th>
                          <th>Supplier</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($pembelian as $item)
                        <tr>
                          <td style="width: 10px">{{ $num++ }}</td>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isoFormat('D MMMM Y') }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ "Rp " . number_format($item->total-$item->diskon - ($item->total-$item->diskon)*($item->ppn/100) ,0,',','.') }}</td>
                          <td>
                            {{-- <div class="row"> --}}
                                <a href="{{ route('pembelian.show', ['pembelian' => $item->id]) }}" class='btn btn-info w-100 mb-2'>Barang Dibeli</a>
                                <button type="button" class="btn btn-success btnUbah w-100 mb-2" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modalUbahPembelian">Ubah</button>
                                <button type="button" class="btn btn-danger w-100 mb-2 btnHapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPembelian">Hapus</button>
                            {{-- </div> --}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.pembelian.modal.confirm_delete')
@include('admin.pembelian.modal.create')
@include('admin.pembelian.modal.edit')


<!-- bootstrap datepicker -->
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

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
    toastr.success("{{ session('success') }}", "Success", toastrOptions);
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    $('#formHapus').attr("action", '/admin/pembelian/'+id);

  });

</script>
@endsection