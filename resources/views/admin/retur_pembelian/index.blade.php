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
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

    <a href="{{ route('retur_pembelian.create') }}" class="btn btn-success ml-2">Tambah</a>

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
                          <th>Total Barang Retur</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($retur_pembelian as $item)
                        <tr>
                          <td style="width: 10px">{{ $num++ }}</td>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>{{ $item->tanggal }}</td>
                          <td>{{ $item->total_barang_diretur }}</td>
                          <td>{{ $item->total }}</td>
                          <td>
                            <div class="row">
                                <a href="#lihat" class='btn btn-info w-100 mb-2'>Lihat</a>
                                <a href="#ubah" class='btn btn-warning w-100 mb-2'>Ubah</a>
                                <button type="button" class="btn btn-danger mb-2 btnHapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPembelian">Hapus</button> 
                            </div>
                          </td>
                        </tr>
                      @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- @include('admin.pembelian.modal.confirm_delete') --}}

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