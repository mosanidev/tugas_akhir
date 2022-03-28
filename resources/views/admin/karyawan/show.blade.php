@extends('admin.layouts.master')

@section('content')

<a href="{{ route('karyawan.index') }}" class="btn btn-link"><- Kembali ke daftar karyawan</a>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Karyawan</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    <div class="row">
        <div class="col-9">
            <div class="px-3 py-4">
                <h5 class="mb-3"><strong>Profil Karyawan</strong></h5>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nama</p><p class="d-inline">{{ $karyawan[0]->nama_depan.' '.$karyawan[0]->nama_belakang }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Jenis Kelamin</p><p class="d-inline">{{ $karyawan[0]->jenis_kelamin }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Tanggal Lahir</p><p class="d-inline">{{ $karyawan[0]->tanggal_lahir }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Email</p><p class="d-inline">{{ $karyawan[0]->email }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nomor Telepon</p><p class="d-inline">{{ $karyawan[0]->nomor_telepon }}</p><br>
            </div>
            </div>
            <div class="col-3">
                <div class="my-4">
                    {{-- @php $foto = isset(auth()->user()->foto) ? asset('images/profil/'.auth()->user()->id.'/'.auth()->user()->foto) : 'https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg'; @endphp --}}
                    <img id="img-profil" src="{{ asset($karyawan[0]->foto) }}" width="182" height="140" class="mx-auto">
                </div>
            </div>
    </div>
</div>

@endsection