@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Stok Opname</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">

        <a href="{{ route('stok_opname.create') }}" class="btn btn-success ml-2" >Tambah</a>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Stok Opname</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              <th style="width: 10px">No</th>
                              <th>Nomor Nota</th>
                              <th>Tanggal</th>
                              <th>Pembuat</th>
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

@endsection