@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Konsinyasi</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahKonsinyasi">Tambah</button>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Konsinyasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Tanggal Buat</th>
                          <th>Tanggal Jatuh Tempo</th>
                          <th>Pemasok</th>
                          <th>Status Bayar</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(isset($konsinyasi))
                        @php $num = 1; @endphp
                        @foreach($konsinyasi as $item)
                          <tr>
                            <td>{{ $item->nomor_nota }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_titip)->isoFormat('DD-MM-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isoFormat('DD-MM-Y') }}</td>
                            <td>{{ $item->nama_supplier }}</td>
                            <td>{{ $item->status_bayar }}</td>
                            <td>

                              @if($item->status_bayar == "Sudah lunas")
                                  <a href="{{ route('konsinyasi.show', ['konsinyasi'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                              @else
                                @if(auth()->user()->jenis == "Manajer")
                                  <button type="button" class="btn btn-secondary w-100 mb-1 btnLunasi" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalLunasiKonsinyasi">Lunasi</button>
                                @endif
                                <a href="{{ route('konsinyasi.show', ['konsinyasi'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                                <a href="{{ route('konsinyasi.edit', ['konsinyasi' => $item->id]) }}" class='btn btn-warning w-100 mb-1'>Ubah</a>
                                <button type="button" class="btn btn-danger btnHapusKonsinyasi w-100 mb-1" data-id="{{$item->id}}" data-nomor-nota="{{ $item->nomor_nota }}" data-toggle="modal" data-target="#modalHapusKonsinyasi">Hapus</button>
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

@include('admin.konsinyasi.modal.create_konsinyasi')
@include('admin.konsinyasi.modal.confirm_delete')
@include('admin.konsinyasi.modal.lunasi_konsinyasi')
@include('admin.konsinyasi.modal.create_konfirmasi_lunasi')

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

  $(document).ready(function() {

    $('.btnIyaLunasi').on('click', function(){

      if($('#nomorNotaRetur').val() == "")
      {
        toastr.error("Harap isi nomor nota retur terlebih dahulu", "Gagal", toastrOptions);
      }
      else 
      {
        $('#modalLunasiKonsinyasi').modal('toggle');
        $('#modalKonfimasiLunasiKonsinyasi').modal('toggle');

      }

    });

    $('.btnIyaKonfirmasiLunasi').on('click', function() {

      $('#formLunasi').submit();
      
      $('#modalKonfimasiLunasiKonsinyasi').modal('toggle');

      $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

    });

    $('.btnLunasi').on('click', function() {

      const id = $(this).attr('data-id');

      $('#formLunasi').attr('action', '/admin/konsinyasi/lunasi/'+id);

      $.ajax({
        type: 'GET',
        url: '/admin/konsinyasi/'+id,
        beforeSend: function() {

        },
        success: function(data){

          $('#nomorNotaKonsinyasi').val(data.nomor_nota);
          $('#totalHutang').val(convertAngkaToRupiah(data.total_hutang));
          // $('#totalKomisi').val(convertAngkaToRupiah(data.total_komisi));
          // $('input[name=total_komisi]').val(data.total_komisi);
          $('input[name=total_hutang]').val(data.total_hutang);

          $('#arrDetailKonsinyasi').val(JSON.stringify(data.detail_konsinyasi));

          if(data.show_nomor_nota_retur)
          {
            $('.divNomorNotaKonsinyasi').html(`<div class="p-2 ml-1">
                                                  <p>Masih ada sisa barang konsinyasi. Harap isi nomor nota retur untuk simpan data retur barang konsinyasi.</p>
                                               </div>
                                               <label class="col-sm-4 col-form-label">Nomor Nota Retur</label>
                                               <div class="col-sm-8">
                                                  <input type="text" class="form-control" name="nomor_nota_retur" id="nomorNotaRetur">
                                               </div>`);
          }
          else
          {
            $('.divNomorNotaKonsinyasi').html("");
          }

        }
      });

    });

    let table = $('#dataTable').DataTable({
      "order": [[ 1, 'asc' ], [2, 'asc']]
    });

    $('.btnHapusKonsinyasi').on('click', function() {

      const nomorNota = $(this).attr('data-nomor-nota');
      const id = $(this).attr('data-id');

      $('.nomorNotaKonsinyasi').html(nomorNota);

      $('#formHapus').attr('action', '/admin/konsinyasi/'+id);

    });

    if("{{ session('error') }}")
    {
      toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
    }
    else if("{{ session('success') }}")
    {
      toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
    }

  });

</script>
@endsection