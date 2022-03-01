@extends('admin.layouts.master')

@section('content')
<a href="{{ route('konsinyasi.index') }}" class="btn btn-link"><- Kembali ke daftar konsinyasi</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Konsinyasi</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
<div class="container-fluid">

    <input type="hidden" value="{{ $konsinyasi[0]->id }}" id="konsinyasi_id">

    <div class="px-2 py-3">
      <div class="row">
        <div class="col-6">
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Nomor Nota</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->nomor_nota }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Tanggal Titip</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->tanggal_titip }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Tanggal Jatuh Tempo</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->tanggal_jatuh_tempo }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Supplier</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->nama_supplier }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Metode Pembayaran</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->metode_pembayaran }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Status Bayar</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ $konsinyasi[0]->status_bayar }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Total komisi</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ "Rp " . number_format($total_komisi,0,',','.') }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-5 col-form-label">Total hutang ke penitip</label>
            <div class="col-sm-7">
              <p class="mt-2">{{ "Rp " . number_format($total_hutang,0,',','.') }}</p>
            </div>
          </div>
        </div>

        </div>
      </div>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Konsinyasi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              <th>Barang</th>
                              <th>Tanggal Kadaluarsa</th>
                              <th>Jumlah Titip</th>
                              <th>Terjual</th>
                              <th>Retur</th>
                              <th>Sisa</th>
                              <th>Jumlah komisi</th>
                              <th>Jumlah hutang ke penitip</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if(isset($detail_konsinyasi))
                            @foreach ($detail_konsinyasi as $item)
                                <tr>
                                  <td class="barangKonsinyasiDiTabel">{{ $item->barang_nama }}</td>
                                  <td>{{ \Carbon\Carbon::parse($item->barang_tanggal_kadaluarsa)->isoFormat("DD MMMM YYYY").", ".\Carbon\Carbon::parse($item->barang_tanggal_kadaluarsa)->isoFormat("HH:mm")." WIB" }}</td>
                                  <td>{{ $item->jumlah_titip }}</td>
                                  <td>{{ $item->terjual }}</td>
                                  <td>{{ $item->retur }}</td>
                                  <td>{{ $item->sisa }}</td>
                                  <td>{{ "Rp " . number_format($item->subtotal_komisi,0,',','.') }}</td>
                                  <td class="subtotalHutang">{{ "Rp " . number_format($item->subtotal_hutang,0,',','.') }}</td>
                                </tr>
                            @endforeach
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</div>

@endsection