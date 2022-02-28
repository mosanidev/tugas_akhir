@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Retur Pembelian</h1>
      </div>
  </div><!-- /.container-fluid -->
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
                                <form action="{{ route('retur_pembelian.show', ['retur_pembelian'=>$item->id]) }}" class="d-inline">
                                  @if($item->pembelian_id != null)
                                    <input type="hidden" name="jenis" value="Pembelian">
                                  @else 
                                    <input type="hidden" name="jenis" value="Konsinyasi">
                                  @endif
                                  <button type="submit" class='btn btn-info'><i class="fas fa-info-circle"></i></button>
                                </form>
                                {{-- <a href="{{ route('retur_pembelian.show', ['retur_pembelian'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a> --}}
                                <a href="{{ route('retur_pembelian.edit', ['retur_pembelian' => $item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>
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

  <!-- Toastr -->
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
  }
  else if("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}", "Error", toastrOptions);
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    // $('#formHapus').attr("action", '/admin/pembelian/'+id);
    alert(id);

  });

</script>
@endsection