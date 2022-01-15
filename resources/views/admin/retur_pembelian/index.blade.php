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
                          <th style="width: 10px">No</th>
                          <th>Nomor Nota</th>
                          <th>Nama Supplier</th>
                          <th>Tanggal Retur</th>
                          <th>Kebijakan Retur</th>
                          <th>Pembuat</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if(isset($retur_pembelian) && count($retur_pembelian) > 0)
                        @if($retur_pembelian[0]->id != null)
                          @php $num = 1; @endphp
                          @foreach($retur_pembelian as $item)
                            <tr>
                              <td style="width: 10px">{{ $num++ }}</td>
                              <td>{{ $item->nomor_nota }}</td>
                              <td>{{ $item->nama_supplier }}</td>
                              <td>{{ $item->tanggal }}</td>
                              <td>{{ $item->kebijakan_retur }}</td>
                              <td>{{ $item->nama_pembuat }}</td>
                              <td>
                                <div class="row">
                                    <a href="#lihat" class='btn btn-info w-100 mb-2'>Lihat</a>
                                    <a href="#ubah" class='btn btn-warning w-100 mb-2'>Ubah</a>
                                    <button type="button" class="btn btn-danger mb-2 btnHapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPembelian">Hapus</button> 
                                </div>
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

  if("{{ session('status') }}" != "")
  {
    toastr.success("{{ session('status') }}");
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    // $('#formHapus').attr("action", '/admin/pembelian/'+id);
    alert(id);

  });

</script>
@endsection