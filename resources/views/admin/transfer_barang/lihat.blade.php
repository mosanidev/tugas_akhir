@extends('admin.layouts.master')

@section('content')

<a href="{{ route('transfer_barang.index') }}" class="btn btn-link"><- Kembali ke daftar transfer barang</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Transfer Barang</h1>
      </div>
  </div>
</section>

<div class="container-fluid">
  <div class="container">
      <div class="row">
        <div class="col-2">
            <p>Nomor Transfer Barang</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ sprintf("%04d", $transfer_barang[0]->id) }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Tanggal</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($transfer_barang[0]->tanggal)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Lokasi Asal</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ $transfer_barang[0]->lokasi_asal }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Lokasi Tujuan</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ $transfer_barang[0]->lokasi_tujuan }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Keterangan</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ $transfer_barang[0]->keterangan }}</p>
        </div>
      </div>
  </div>

  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Detail Transfer Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Barang</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Jumlah Dipindah</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($detail_transfer_barang as $item)
                        <tr>
                          <td>{{ $item->kode." - ".$item->nama }}</td>
                          <td>{{ $item->tanggal_kadaluarsa }}</td>
                          <td>{{ $item->kuantitas }}</td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

@endsection