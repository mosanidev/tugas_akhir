@extends('admin.layouts.master')

@section('content')
<a href="{{ route('konsinyasi.index') }}" class="btn btn-link"><- Kembali ke daftar konsinyasi</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Konsinyasi</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    <input type="hidden" value="{{ $konsinyasi[0]->id }}" id="konsinyasi_id">

    <div class="px-2 py-3">
      <div class="row">
        <div class="col-6">
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Nomor Nota</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->nomor_nota }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Tanggal Titip</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->tanggal_titip }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Tanggal Jatuh Tempo</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->tanggal_jatuh_tempo }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Supplier</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->nama_supplier }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Metode Pembayaran</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->metode_pembayaran }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Status</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->status_bayar }}</p>
            </div>
          </div>
        </div>

        </div>
      </div>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Konsinyasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              <th style="width: 10px">No</th>
                              <th>Barang</th>
                              <th>Tanggal Kadaluarsa</th>
                              <th>Jumlah Titip</th>
                              <th>Terjual</th>
                              <th>Retur</th>
                              <th>Sisa</th>
                              {{-- <th>Stok Saat Ini</th> --}}
                              <th>Yang harus dibayar</th>
                            </tr>
                        </thead>
                        <tbody>
                          {{-- {{dd($detail_konsinyasi)}} --}}
                          @if(isset($detail_konsinyasi))
                            @php $num = 1; @endphp
                            @foreach ($detail_konsinyasi as $item)
                                <tr>
                                  <td>{{ $num++ }}</td>
                                  <td class="barangKonsinyasiDiTabel">{{ $item->barang_nama }}</td>
                                  <td>{{ $item->barang_tanggal_kadaluarsa }}</td>
                                  <td>{{ $item->jumlah_titip }}</td>
                                  <td>{{ $item->terjual }}</td>
                                  <td>{{ $item->retur }}</td>
                                  <td>{{ $item->sisa }}</td>
                                  {{-- <td>{{ $item->jumlah_stok }}</td> --}}
                                  <td class="subtotalHutang">{{ "Rp " . number_format($item->subtotal_hutang,0,',','.') }}</td>
                                </tr>
                            @endforeach
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>

@include('admin.konsinyasi.modal.confirm_lunasi')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
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

  $(document).ready(function() {

    $('#selectBarangKonsinyasi').select2({
        dropdownParent: $("#modalTambahBarangKonsinyasi"),
        theme: 'bootstrap4'
    });

    $('#selectSupplier').select2({
        dropdownParent: $("#modalTambahBarangKonsinyasi"),
        theme: 'bootstrap4'
    });

    $('#btnTambah').on('click', function() {

      $('#konsinyasi_id').val("{{ $konsinyasi[0]->id   }}");

    });

    $('#btnTambahBarangKonsinyasi').on('click', function() {

      let cariBarangSejenis = false;
      for(let i = 0; i < $('.barangKonsinyasiDiTabel').length; i++)
      {
        if($('#selectBarangKonsinyasi :selected').text() == $('.barangKonsinyasiDiTabel')[i].innerText)
        {
          cariBarangSejenis = true;
          break;
        }
      }

      if(cariBarangSejenis)
      {
        alert("Sudah Ada barang yang sama di tabel");
      }     
      else 
      {
        $('#formTambah').submit();
      }   


    });


    let totalHutang = 0;
    $('.subtotalHutang').each(function( index ) {
      totalHutang += parseInt(convertRupiahToAngka($('.subtotalHutang')[index].innerText));
    });

    $('#totalHutang').html(convertAngkaToRupiah(totalHutang));

    $('#btnLunasi').on('click', function() {

      let id = $('#konsinyasi_id').val();

      $('#lunasiTotalHutang').val(totalHutang);

      let arrDetailKonsinyasi  = <?php echo json_encode($detail_konsinyasi); ?>;

      $('#arrLunasi').val(JSON.stringify(arrDetailKonsinyasi));

      $('#formLunasi').attr('action', '/admin/konsinyasi/lunasi/'+id);


    });

  });


</script>
@endsection