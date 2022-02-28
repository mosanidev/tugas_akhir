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
            <label class="col-sm-4 col-form-label">Nomor Nota Pembelian dari Pemasok</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $pembelian[0]->nomor_nota_dari_supplier }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Buat Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $pembelian[0]->tanggal }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $pembelian[0]->tanggal_jatuh_tempo }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Status Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $pembelian[0]->status_bayar }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Total Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2" id="totalPembelianRupiah">{{ "Rp " . number_format($pembelian[0]->total,0,',','.') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Potongan Dana</label>
            <div class="col-sm-8">
                <input type="hidden" name="total" id="totalReturAngka" value="">
                <p class="mt-2" id="totalReturRupiah">{{ "Rp " . number_format($retur_pembelian[0]->total,0,',','.') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Total Pembelian setelah Potongan Dana</label>
            <div class="col-sm-8">
                <p class="mt-2" id="totalAkhirRupiah">{{ "Rp " . number_format($pembelian[0]->total-$retur_pembelian[0]->total,0,',','.') }}</p>
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
                                <th style="width: 70%;">Barang Retur</th>
                                <th>Tanggal Kadaluarsa Barang Retur</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Diskon Potongan Harga</th>
                                <th>Jumlah Beli</th>
                                <th>Jumlah Retur</th>
                                <th>Subtotal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                            @foreach($detail_retur_pembelian as $item)
                                <tr>
                                    <td>{{ $item->kode." - ".$item->nama }}</td>
                                    @if($item->barang_konsinyasi == 0)
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa_barang_retur)->isoFormat('DD MMMM YYYY') }}</td>
                                    @else
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa_barang_retur)->isoFormat('DD MMMM YYYY').", ".\Carbon\Carbon::parse($item->tanggal_kadaluarsa_barang_retur)->format('HH:mm')." WIB" }}</td>
                                    @endif
                                    <td>{{ $item->satuan }}</td>
                                    <td>{{ "Rp " . number_format($item->harga_beli,0,',','.') }}</td>
                                    <td>{{ "Rp " . number_format($item->diskon_potongan_harga,0,',','.') }}</td>
                                    <td>{{ $item->kuantitas }}</td>
                                    <td>{{ $item->kuantitas_barang_retur }}</td>
                                    <td>{{ "Rp ". number_format($item->subtotal,0,',','.') }}</td>
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