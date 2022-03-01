@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Retur Pembelian</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahRetur" data-dismiss="#modalTambahRetur" id="btnTambahRetur">Tambah</button>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Retur Pembelian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Tanggal Retur</th>
                          <th>Kebijakan Retur</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(isset($retur_pembelian) && count($retur_pembelian) > 0)
                        @if($retur_pembelian[0]->id != null)
                          @php $num = 1; @endphp
                          @foreach($retur_pembelian as $item)
                            <tr>
                              <td>{{ $item->nomor_nota }}</td>
                              <td>{{ $item->tanggal }}</td>
                              <td>{{ $item->kebijakan_retur }}</td>
                              <td>
                                {{-- <form action="{{ route('retur_pembelian.show', ['retur_pembelian'=>$item->id]) }}" class="d-inline">
                                  @if($item->pembelian_id != null)
                                    <input type="hidden" name="jenis" value="Pembelian">
                                  @else 
                                    <input type="hidden" name="jenis" value="Konsinyasi">
                                  @endif
                                  <button type="submit" class='btn btn-info'><i class="fas fa-info-circle"></i></button>
                                </form> --}}
                                {{-- <form action="{{ route('retur_pembelian.detail', ['retur_pembelian' => $item->id]) }}">
                                  <input type="hidden" name="kebijakan_retue">
                                </form> --}}
                                <a href="{{ route('retur_pembelian.detail', ['retur_pembelian' => $item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                                <button type="button" class="btn btn-danger btnHapus" data-id="{{$item->id}}" data-nomor-nota="{{ $item->nomor_nota }}" data-toggle="modal" data-target="#modalHapusPembelian"><i class="fas fa-trash"></i></button>
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

@include('admin.retur_pembelian.modal.create')
@include('admin.retur_pembelian.modal.confirm_delete')

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

  // let table = $('#dataTable').DataTable({
  //     "order": [[ 1, 'desc' ]]
  // });

  $('.btnHapus').on('click', function() {

    $('#modalKonfirmasiHapusReturPembelian').modal('toggle');
    let id = $(this).attr('data-id');
    let nomorNota = $(this).attr('data-nomor-nota');
    $('.nomorNotaRetur').html(nomorNota);
    $('#formHapus').attr("action", '/admin/retur_pembelian/'+id);

  });

</script>
@endsection