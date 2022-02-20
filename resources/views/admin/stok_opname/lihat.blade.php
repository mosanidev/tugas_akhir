@extends('admin.layouts.master')

@section('content')

<a href="{{ route('stok_opname.index') }}" class="btn btn-link"><- Kembali ke daftar stok opname</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Stok Opname</h1>
      </div>
  </div>
</section>

<div class="container-fluid">
  <div class="container">
      <div class="row">
        <div class="col-2">
            <p>Nomor Stok Opname</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ sprintf("%04d", $stok_opname[0]->nomor) }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Tanggal</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($stok_opname[0]->tanggal)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Pembuat</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ $stok_opname[0]->nama_depan." ".$stok_opname[0]->nama_belakang }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Lokasi Stok</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ $stok_opname[0]->lokasi_stok }}</p>
        </div>
      </div>
  </div>

  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Detail Stok Opname</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Barang</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Stok di sistem</th>
                        <th>Stok di toko</th>
                        <th>Jumlah selisih</th>
                        <th>Keterangan</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($detail_stok_opname as $item)
                        <tr>
                          <td>{{ $item->kode." - ".$item->nama }}</td>
                          <td>{{ $item->tanggal_kadaluarsa }}</td>
                          <td>{{ $item->stok_di_sistem }}</td>
                          <td>{{ $item->stok_di_toko }}</td>
                          @if($item->jumlah_selisih > 0)
                            <td>{{ "+".$item->jumlah_selisih }}</td>
                          @else 
                            <td>{{ $item->jumlah_selisih }}</td>
                          @endif
                          <td>{{ $item->keterangan }}</td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @if(count($history_edit) > 0)
    @foreach($history_edit as $item)
      <p class="ml-5"><em>Telah diubah oleh {{$item->nama_depan." ".$item->nama_belakang}} pada {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm') }} WIB</em></p>
    @endforeach
  @endif

@endsection