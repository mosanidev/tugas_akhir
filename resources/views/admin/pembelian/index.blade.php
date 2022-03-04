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

    {{-- <a href="{{ route('pembelian.create') }}" class="btn btn-success">Tambah</a> --}}

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahPembelian">Tambah</button>

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
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('Y-MM-D') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isoFormat('Y-MM-D') }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>
                            {{ $item->status_bayar }}
                          </td>
                          <td>

                            @if($item->status_retur == "Tidak ada retur" && $item->status_bayar == "Belum lunas")
                              @if(auth()->user()->jenis == "Manajer")
                                <button class='btn btn-secondary btnLunasi w-100 mb-1' data-toggle="modal" data-target="#modalLunasiPembelian" data-id="{{ $item->id }}">Lunasi</button>
                              @endif 
                              <a href="{{ route('pembelian.show', ['pembelian'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                              <a href="{{ route('pembelian.edit', ['pembelian'=>$item->id]) }}" class='btn btn-warning w-100 mb-1'>Ubah</a>
                              <button class='btn btn-danger btnHapus w-100' data-id="{{ $item->id }}" data-nomor-nota="{{ $item->nomor_nota_dari_supplier }}" data-toggle="modal" data-target="#modalKonfirmasiHapusPembelian">Hapus</button>
                            @elseif($item->status_retur == "Ada retur" && $item->status_bayar == "Belum lunas")
                              @if(auth()->user()->jenis == "Manajer")
                                <button class='btn btn-secondary btnLunasi w-100 mb-1' data-toggle="modal" data-target="#modalLunasiPembelian" data-id="{{ $item->id }}">Lunasi</button>
                              @endif
                              <a href="{{ route('pembelian.show', ['pembelian'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                            @elseif($item->status_bayar == "Sudah lunas")
                              <a href="{{ route('pembelian.show', ['pembelian'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
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
@include('admin.pembelian.modal.lunasi')
@include('admin.pembelian.modal.konfirmasi_lunasi')
@include('admin.pembelian.modal.create_pembelian')

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
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: new Date()
  });

  $('#datepickerTglJatuhTempo').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: new Date()
  });

  $('#datepickerTglJatuhTempoUbah').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
  });

  $('#datepickerTglUbah').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
  });

  $('#datepickerTglJatuhTempo').on('change', function() {

    let dateNow = moment().format("d-m-Y");

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

  $('.btnLunasi').on('click', function() {

    const id = $(this).attr('data-id');
    
    $('#formLunasi').attr('action', '/admin/pembelian/lunasi/'+id);

    $.ajax({
      type: 'GET',
      url: '/admin/pembelian/'+id,
      success: function(data) {

        $('input[name=nomor_pembelian]').val(data.pembelian[0].id);
        $('input[name=nomor_nota_dari_supplier]').val(data.pembelian[0].nomor_nota_dari_supplier);
        $('input[name=total_pembelian]').val(data.pembelian[0].total);
        $('#totalPembelian').val(convertAngkaToRupiah(data.pembelian[0].total));

        if(data.pembelian[0].total_retur)
        {
          $('.divPotonganDana').html(`<label class="col-sm-4 col-form-label">Potongan Dana Retur</label>
                                      <div class="col-sm-8">
                                        <input type="text" class="form-control" value="` + convertAngkaToRupiah(data.pembelian[0].total_retur) + `" readonly>
                                      </div>`);

          $('.divTotalAkhirPembelian').html(`<label class="col-sm-4 col-form-label">Total Pembelian setelah Dipotong Retur</label>
                                              <div class="col-sm-8">
                                                <input type="text" class="form-control" value="` + convertAngkaToRupiah(data.pembelian[0].total-data.pembelian[0].total_retur) + `" readonly>
                                              </div>`);
        }
        else
        {
          $('.divPotonganDana').html("");
          $('.divTotalAkhirPembelian').html("");
        }
      }
    });

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

  $('.btnIyaLunasi').on('click', function() {

    $('#modalLunasiPembelian').modal('toggle');

    $('#modalKonfimasiLunasiPembelian').modal('toggle');

  });

  $('.btnIyaKonfirmasiLunasi').on('click', function(){

    $('#modalKonfimasiLunasiPembelian').modal('toggle');

    $('#formLunasi').submit();

    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

  });

  $('#rentangTanggalBuat').daterangepicker({
      startDate: moment().startOf('days'),
      endDate: moment().startOf('days'),
      locale: {
        format: 'DD-MM-YYYY'
      }
  });

  $('#rentangTanggalJatuhTempo').daterangepicker({
      startDate: moment().startOf('days'),
      endDate: moment().startOf('days'),
      locale: {
        format: 'DD-MM-YYYY'
      }
  });

  $(document).ready(function() {

    let table = $('#dataTable').DataTable({
      "order": [[ 0, 'desc' ]]
    });
    
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