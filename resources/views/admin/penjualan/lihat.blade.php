@extends('admin.layouts.master')

@section('content')

    <h3>Detail Penjualan</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota</label>
              <div class="col-sm-10">
                <p>{{ $penjualan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal</label>
              <div class="col-sm-10">
                  <p>{{ \Carbon\Carbon::parse($penjualan[0]->tanggal)->isoFormat('D MMMM Y') }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Pelanggan</label>
              <div class="col-sm-10">
                <p>{{ $penjualan[0]->nama_depan." ".$penjualan[0]->nama_belakang }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Metode Transaksi</label>
              <div class="col-sm-10">
                <p>{{ $penjualan[0]->metode_transaksi }}</p>
              </div>
            </div>
            <hr>
            <h5>Pembayaran</h5>
            <br>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Metode Transaksi</label>
                <div class="col-sm-10">
                  <p>{{ $penjualan[0]->metode_pembayaran }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status Pembayaran</label>
                <div class="col-sm-10">
                  <p>{{ $penjualan[0]->status }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total</label>
                <div class="col-sm-10">
                  <p>{{ "Rp " . number_format($detail_penjualan[0]->total,0,',','.') }}</p>
                </div>
            </div>
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Barang</th>
                                    <th>Harga Jual</th>
                                    <th>Potongan Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                @php $num = 1; @endphp
                                @for($i=0; $i < count($detail_penjualan); $i++)
                                    <tr>
                                        <td>{{ $num++ }}</td>
                                        <td>{{ $detail_penjualan[$i]->nama }}</td>
                                        <td>{{ "Rp " . number_format($detail_penjualan[$i]->harga_jual,0,',','.')  }}</td>
                                        <td>{{ "Rp " . number_format($detail_penjualan[$i]->diskon_potongan_harga,0,',','.')  }}</td>
                                        <td>{{ $detail_penjualan[$i]->kuantitas }}</td>
                                        <td>{{ "Rp " . number_format($detail_penjualan[$i]->subtotal,0,',','.')  }}</td>                                    </tr>

                                @endfor
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

@endsection