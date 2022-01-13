@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('stok_opname.index') }}" class="btn btn-link"><- Kembali ke daftar stok opname</a>

    <h3>Tambah Stok Opname</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('stok_opname.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_titip" autocomplete="off" id="datepickerTglTitip" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pembuat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="nama_pembuat" autocomplete="off" value="{{ auth()->user()->id.' - '.auth()->user()->nama_depan.' '.auth()->user()->nama_belakang }}" readonly>
                  </div>   
                </div>
              </div>

              <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangKonsinyasi" id="btnTambah">Tambah</button>

              <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Konsinyasi </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Barang</th>
                                  <th>Stok di Sistem</th>
                                  <th>Stok di Toko</th>
                                  <th>Selisih</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>
        </form>
    </div>

@endsection