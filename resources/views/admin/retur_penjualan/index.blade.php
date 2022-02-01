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
            <h6 class="m-0 font-weight-bold text-primary">Tabel Retur Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Pelanggan</th>
                          <th>Tanggal Jual</th>
                          <th>Tanggal Retur</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>K089098908078KJ</td>
                        <td>Siti Zubaidah</td>
                        <td>2022-01-31 16:12</td>
                        <td>2022-02-01 16:12</td>
                        <td>
                            <a href="#lihat" class='btn btn-info w-100 mb-2'>Lihat</a>
                            <a href="#ubah" class='btn btn-warning w-100 mb-2'>Terima</a>
                            <button type="button" class="btn btn-danger mb-2 btnHapus">Tolak</button> 
                        </td>
                      {{-- @if(isset($retur_penjualan) && count($retur_penjualan) > 0)
                        @if($retur_penjualan[0]->id != null)
                          @php $num = 1; @endphp
                          @foreach($retur_penjualan as $item)
                            <tr>
                              <td style="width: 10px">{{ $num++ }}</td>
                              <td>{{ $item->nomor_nota }}</td>
                              <td>{{ $item->pelanggan }}</td>
                              <td>{{ $item->tanggal_jual }}</td>
                              <td>{{ $item->tanggal_retur }}</td>
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
                      @endif --}}
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
    toastr.success("{{ session('success') }}");
  }
  else if("{{ session('error') }}" != "")
  {
    toastr.error("{{ session('error') }}");
  }

  $('.btnHapus').on('click', function() {

    let id = $(this).attr('data-id');
    // $('#formHapus').attr("action", '/admin/pembelian/'+id);
    alert(id);

  });

</script>
@endsection