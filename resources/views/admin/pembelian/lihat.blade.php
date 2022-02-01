@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Data Pembelian</h3>

    <div class="px-2 py-3">
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota</label>
              <div class="col-sm-8">
                <p>{{ $pembelian[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                <div class="col-sm-8">
                  <p>{{ \Carbon\Carbon::parse($pembelian[0]->tanggal)->isoFormat('D MMMM Y') }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-8">
                  <p>{{ \Carbon\Carbon::parse($pembelian[0]->tanggal_jatuh_tempo)->isoFormat('D MMMM Y') }}</p> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                  <p>{{ $pembelian[0]->nama_supplier }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <p>{{ $pembelian[0]->metode_pembayaran }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  <p>{{ "Rp " . number_format($pembelian[0]->diskon,0,',','.') }}</p>             
                 </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  <p>{{ "Rp " . number_format($pembelian[0]->ppn,0,',','.') }}</p>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Bayar</label>
                <div class="col-sm-8">
                  <p>{{ $pembelian[0]->status_bayar }}</p>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Retur</label>
                <div class="col-sm-8">
                  <p>{{ $pembelian[0]->status_retur }}</p>   
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                  <p>{{ "Rp " . number_format($pembelian[0]->total,0,',','.') }}</p>   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir</label>
                <div class="col-sm-8">
                  <p>{{ "Rp " . number_format($pembelian[0]->total-$pembelian[0]->diskon-$pembelian[0]->ppn,0,',','.') }}</p>  
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
                                  <th>Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Beli</th>
                                  <th>Kuantitas</th>
                                  <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail_pembelian as $item)
                                  <tr>
                                    <td>{{ $item->kode." - ".$item->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isoFormat('D MMMM Y') }}</td>
                                    <td>{{ "Rp " . number_format($item->harga_beli,0,',','.') }}</td>
                                    <td>{{ $item->kuantitas }}</td>
                                    <td>{{ "Rp " . number_format($item->subtotal,0,',','.') }}</td>
                                  </tr>
                                @endforeach
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