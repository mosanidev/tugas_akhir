@extends('admin.layouts.master')

@section('content')

    <h3>Tukar Barang</h3>

    <div class="px-2 py-3">

        <form method="POST" action="{{ route('detail_retur_pembelian.store') }}">
        @csrf

        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nomor Nota Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nomor_nota }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Kebijakan Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->kebijakan_retur }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Pembuat</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nama_pembuat }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nomor Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nomor_nota_pembelian }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Buat Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal_buat_nota_beli }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal_jatuh_tempo_beli }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Status Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p>
            </div>
        </div>

        <button type="button" class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTukarBarang">Tambah</button>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Tukar Barang </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Tanggal Kadaluarsa Asal</th>
                                <th class="d-none">ID Barang Asal</th>
                                <th>Barang Asal</th>
                                <th>Kuantitas Barang Asal</th>
                                <th>Tanggal Kadaluarsa Ganti</th>
                                <th class="d-none">ID Barang Ganti</th>
                                <th>Barang Ganti</th>
                                <th>Kuantitas Barang Ganti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
            {{-- <input type="hidden" name="pembelian_id" value="{{ $retur_pembelian[0]->pembelian_id }}">
            <input type="hidden" name="retur_pembelian_id" value="{{ $retur_pembelian[0]->id }}">
            <input type="hidden" id="dataBarangRetur" value="" name="barangRetur"/> --}}
            <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
        </form>
        
    </form>
</div>

  @include('admin.retur_pembelian.barang_retur.tukar_barang.create')

  <script type="text/javascript">


  </script>
@endsection