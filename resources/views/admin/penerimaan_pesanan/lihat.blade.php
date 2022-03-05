@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('penerimaan_pesanan.index') }}" class="btn btn-link"><- Kembali ke daftar penerimaan pesanan</a>

    <h3>Tambah Penerimaan Pesanan</h3>

    <div class="px-2 py-3">

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota Pemesanan</label>
              <div class="col-sm-8">
                  <p class="mt-2">{{ $pemesanan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                <div class="col-sm-8">
                    <p class="mt-2">{{ \Carbon\Carbon::parse($pemesanan[0]->tanggal)->isoFormat('DD-MM-Y') }}</p> 
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Terima Pesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <p class="mt-2">{{ \Carbon\Carbon::parse($penerimaan_pesanan[0]->tanggal)->isoFormat('DD-MM-Y') }}</p>
                  </div>   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pemasok</label>
                <div class="col-sm-8">
                    <p class="mt-2">{{ $pemesanan[0]->nama_pemasok }}</p>
                </div>
            </div>
              
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diterima</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Kuantitas Pesan</th>
                                  <th>Kuantitas Terima</th>
                                  <th>Selisih</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                @foreach($detail_penerimaan_pesanan as $item)
                                    <tr>
                                        <td>{{ $item->kode." - ".$item->nama }}</td>
                                        <td>{{ $item->jumlah_pesan }}</td>
                                        <td>{{ $item->jumlah_terima }}</td>
                                        <td>{{ $item->jumlah_pesan - $item->jumlah_terima }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

@endsection