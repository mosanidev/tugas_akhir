@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('retur_pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar retur pembelian</a>

    <h3>Retur Pembelian</h3>

    <div class="px-2 py-3">
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
            <label class="col-sm-4 col-form-label">Nomor Nota Konsinyasi</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $konsinyasi[0]->nomor_nota }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Titip</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $konsinyasi[0]->tanggal_titip }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Konsinyasi</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $konsinyasi[0]->tanggal_jatuh_tempo }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Status Konsinyasi</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $konsinyasi[0]->status_bayar }}</p>
            </div>
        </div>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Retur </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Barang Retur</th>
                                <th>Tanggal Kadaluarsa Barang Retur</th>
                                <th>Satuan</th>
                                <th>Jumlah Titip</th>
                                <th>Jumlah Retur</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            @foreach($detail_retur_pembelian as $item)
                                <tr>
                                    <td>{{ $item->kode." - ".$item->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa_barang_retur)->isoFormat('DD MMMM YYYY').", ".\Carbon\Carbon::parse($item->tanggal_kadaluarsa_barang_retur)->format('HH:mm')." WIB" }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>{{ $item->jumlah_titip }}</td>
                                    <td>{{ $item->kuantitas_barang_retur }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
            
</div>

@endsection