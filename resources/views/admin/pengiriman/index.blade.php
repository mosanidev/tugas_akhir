@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>Daftar Pengiriman Penjualan</h1>
      </div>
  </div>
</section>

<div class="container-fluid">

    <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalPilihPengirimanPenjualan" id="tambahPengirimanPenjualan">Tambah</button>

    <form action="{{ route('order.create') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-info ml-5">TEst Order API</button>
    </form>

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
                          <th>Pelanggan</th>
                          <th>Metode Transaksi</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.pengiriman.modal.create')

<script type="text/javascript">




</script>
@endsection