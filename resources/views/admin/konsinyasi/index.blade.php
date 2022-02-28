@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Konsinyasi</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahKonsinyasi">Tambah</button>

    {{-- <a href="{{ route('konsinyasi.create') }}" class="btn btn-success ml-2">Tambah</a> --}}

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
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_titip)->isoFormat('D MMMM Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isoFormat('D MMMM Y') }}</td>
                            <td>{{ $item->nama_supplier }}</td>
                            <td>{{ $item->status_bayar }}</td>
                            <td>
                              <button type="button" class="btn btn-secondary w-100 mb-1" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusKonsinyasi">Lunasi</button>
                              <a href="{{ route('konsinyasi.show', ['konsinyasi'=>$item->id]) }}" class='btn btn-info w-100 mb-1'>Lihat</a>
                              <a href="{{ route('konsinyasi.edit', ['konsinyasi' => $item->id]) }}" class='btn btn-warning w-100 mb-1'>Ubah</a>
                              <button type="button" class="btn btn-danger btnHapusKonsinyasi w-100 mb-1" data-id="{{$item->id}}" data-nomor-nota="{{ $item->nomor_nota }}" data-toggle="modal" data-target="#modalHapusKonsinyasi">Hapus</button>
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

    $('#btnLunasi').on('click', function(){

      let id = $('#btnLunasi').attr('data-id');
      let totalHutang = $('#btnLunasi').attr('data-total-hutang');

      $('#formLunasi').attr('action', '/admin/konsinyasi/lunasi/'+id);

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