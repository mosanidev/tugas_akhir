@extends('admin.layouts.master')

@section('content')

<a href="{{ route('periode_diskon.index') }}" class="btn btn-link"><- Kembali ke daftar periode diskon</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Periode Diskon</h1>
      </div>
  </div>
</section>

<div class="container-fluid">
  <div class="container">
      <div class="row">
        <div class="col-2">
            <p>Tanggal Dimulai</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($periode_diskon[0]->tanggal_dimulai)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Tanggal Berakhir</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($periode_diskon[0]->tanggal_berakhir)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
      @if($periode_diskon[0]->keterangan != "")
        <div class="row">
            <div class="col-2">
                <p>Keterangan</p>
            </div>
            <div class="col-10">
                <p class="text-left">{{ $periode_diskon[0]->keterangan }}</p>
            </div>
        </div>
      @endif
  </div>

  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diskon</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Harga Asli</th>
                        <th>Potongan Harga</th>
                        <th>Harga Akhir</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($barang_diskon as $item)
                        <tr>
                          <td>{{ $item->kode." - ".$item->nama }}</td>
                          <td>{{ "Rp " . number_format($item->harga_jual,0,',','.') }}</td>
                          <td>{{ "Rp " . number_format($item->diskon_potongan_harga,0,',','.') }}</td>
                          <td>{{ "Rp " . number_format($item->harga_jual-$item->diskon_potongan_harga,0,',','.') }}</td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

@endsection