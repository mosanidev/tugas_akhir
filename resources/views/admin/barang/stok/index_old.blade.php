@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Stok Barang</strong></h1>
      </div>
  </div>
  <hr>
  <p class="mt-2 ml-2">Filter : </p>
  
  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Jenis barang</p> 
    </div>
    <div class="col-9 divFilterJenis">
        <select class="form-control w-50 selectFilter" id="selectFilterJenis">
          <option selected>Semua</option>
          @foreach($jenis_barang as $item)
            <option>{{ $item->nama_jenis }}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Tipe barang</p> 
    </div>
    <div class="col-9 divFilterTipe">
        <select class="form-control w-50 selectFilter" id="selectFilterTipe">
          <option selected>Semua</option>
          <option>Barang reguler</option>
          <option>Barang konsinyasi</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Masa durasi kadaluarsa</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterKadaluarsa">
          <option selected>Semua</option>
            <option>Kemarin</option>
            <option>Dalam 3 bulan</option>
            <option>Dalam 6 bulan</option>
            <option>Lebih dari 6 bulan</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Status jumlah stok di gudang</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterStatusJumlahStokGudang">
          <option selected>Semua</option>
            <option>Diatas stok minimum</option>
            <option>Dibawah stok minimum</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Status jumlah stok di rak</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterStatusJumlahStokRak">
          <option selected>Semua</option>
            <option>Diatas stok minimum</option>
            <option>Dibawah stok minimum</option>
        </select>
    </div>
  </div>

</section>

<div class="container-fluid">
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Stok Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10%">Kode</th>
                        <th style="width: 10%">Nama</th>
                        <th style="width: 8%" class="d-none">Jenis</th>
                        <th style="width: 8%" class="d-none">Tipe</th>
                        <th style="width: 8%">Satuan</th>
                        <th style="width: 8%;">Tanggal Kadaluarsa</th>
                        <th style="width: 8%">Jumlah Stok di Gudang</th>
                        <th style="width: 8%">Jumlah Stok di Rak</th>
                        <th style="width: 8%">Batasan Stok Minimum</th>
                        {{-- <th style="width: 8%">Kadaluarsa</th> --}}
                        {{-- <th style="width: 8%">Aksi</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                      
                      @foreach($barang as $item)


                        <tr>
                            <td>{{$item->kode}}</td>
                            <td>{{$item->nama}}</td>
                            <td class="d-none">{{$item->nama_jenis}}</td>
                            <td class="d-none">{{$item->barang_konsinyasi}}</td>
                            <td>{{$item->satuan}}</td>
                            <td>{{ "-" }}</td>
                            <td>{{ "0" }}</td>
                            <td>{{ "0" }}</td>
                            <td>{{ $item->batasan_stok_minimum }}</td>
                        </tr>

                      @endforeach

                      @foreach($barangStok as $item)


                        <tr>
                            <td>{{$item->kode}}</td>
                            <td>{{$item->nama}}</td>
                            <td class="d-none">{{$item->nama_jenis}}</td>
                            <td class="d-none">{{$item->barang_konsinyasi}}</td>
                            <td>{{$item->satuan}}</td>
                            <td>{{ $item->tanggal_kadaluarsa }}</td>
                            <td>{{  $item->jumlah_stok }}</td>
                            <td>{{ $item->jumlah_stok_di_rak }}</td>
                            <td>{{ $item->batasan_stok_minimum }}</td>
                        </tr>

                      @endforeach
                        
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.barang.modal.detail_stok_barang')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  
  <!-- Moment  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function() {

        
      
    });

  </script>


@endsection