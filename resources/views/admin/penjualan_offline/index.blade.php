@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Penjualan Offline</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    {{-- <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahPenjualanOffline">Tambah</button> --}}

    <a href="{{ route('penjualanoffline.create') }}" class="btn btn-success ml-2">Tambah</a>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th style="width: 10px">No</th>
                          <th>Nomor Nota</th>
                          <th>Tanggal</th>
                          <th>Metode Pembayaran</th>
                          <th>Total</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($penjualan as $item)
                        <tr>
                          <td style="width: 10px">{{ $num++ }}</td>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm:ss')." WIB" }}</td>
                          <td>{{ $item->metode_pembayaran }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>
                            <a href="{{ route('penjualan.show', ['penjualan'=>$item->nomor_nota]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

  if("{{ session('success') }}" != "")
  {
    toastr.success("{{ session('success') }}", "Success", toastrOptions);
  }

</script>
@endsection