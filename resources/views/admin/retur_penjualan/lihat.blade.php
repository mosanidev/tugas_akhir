@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('retur_penjualan.index') }}" class="btn btn-link text-info"><- Kembali ke daftar retur penjualan</a>

    <h3>Detail Penjualan</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $retur_penjualan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Penjualan</label>
                <div class="col-sm-10">
                    <p class="mt-2">{{ \Carbon\Carbon::parse($retur_penjualan[0]->tanggal_jual)->isoFormat('DD-MM-Y') }}</p>
                </div>
              </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal Pengajuan Retur</label>
              <div class="col-sm-10">
                  <p class="mt-2">{{ \Carbon\Carbon::parse($retur_penjualan[0]->tanggal_retur)->isoFormat('DD-MM-Y') }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Pelanggan</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $retur_penjualan[0]->nama_depan." ".$retur_penjualan[0]->nama_belakang }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                  <p class="mt-2">{{ $retur_penjualan[0]->status }}</p>
                </div>
              </div>
            
            <hr>
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diretur</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Kuantitas Diretur</th>
                                    <th>Alasan Retur</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                @php $num = 1; @endphp
                                @for($i=0; $i < count($detail_retur_penjualan); $i++)
                                    <tr>
                                        <td>{{ $detail_retur_penjualan[$i]->kode." - ".$detail_retur_penjualan[$i]->nama }}</td>
                                        <td>{{ $detail_retur_penjualan[$i]->kuantitas_barang_retur }}</td>
                                        <td>{{ $detail_retur_penjualan[$i]->alasan_retur  }}</td>                                   
                                    </tr>
                                @endfor
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
    <script type="text/javascript">

        $(document).ready(function() {

          

        });


    </script>

@endsection