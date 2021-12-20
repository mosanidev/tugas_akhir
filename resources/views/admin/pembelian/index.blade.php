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
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

    {{-- <a href="{{ route('pembelian.create') }}" class="btn btn-success ml-2">Tambah</a> --}}
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
                          <th>Tanggal</th>
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
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ $item->total }}</td>
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

  $('#datepickerTglUbah').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
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
            $('#selectSupplierUbah').val(data.pembelian[0].supplier_id).change();
            
            if(data.pembelian[0].sistem_konsinyasi == 1)
            {
              $('#checkKonsinyasiUbah').prop('checked', true);
            }

            $('#formUbah').attr('action', '/admin/pembelian/'+pembelian_id);

          }

      });

  });

  if("{{ session('status') }}" != "")
  {
    toastr.success("{{ session('status') }}");
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    $('#formHapus').attr("action", '/admin/pembelian/'+id);

  });

</script>
@endsection