@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pemesanan.index') }}" class="btn btn-link"><- Kembali ke daftar pemesanan</a>

    <h3>Tambah Pemesanan</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota</label>
              <div class="col-sm-8">
                <p>{{ $pemesanan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->tanggal }}</p>  
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Perkiraan Diterima</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->perkiraan_tanggal_terima }}</p>   
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Bayar</label>
                <div class="col-sm-8">
                    <p>{{ $pemesanan[0]->tanggal_jatuh_tempo }}</p> 
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                    <p>{{ $pemesanan[0]->nama_supplier }}</p>
                </div>
            </div>
              
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                    <p>{{ $pemesanan[0]->metode_pembayaran }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                    <p>{{ "Rp " . number_format($pemesanan[0]->diskon,0,',','.') }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                    <p>{{ "Rp " . number_format($pemesanan[0]->ppn,0,',','.') }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Bayar</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->status_bayar }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <p>{{ "Rp " . number_format($pemesanan[0]->total,0,',','.') }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir</label>
                <div class="col-sm-8">
                    <p>{{ "Rp " . number_format($pemesanan[0]->total-$pemesanan[0]->diskon-$pemesanan[0]->ppn,0,',','.') }}</p>
                </div>
            </div>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Dipesan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Harga Pesan</th>
                                  <th>Kuantitas</th>
                                  <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                @foreach($detail_pemesanan as $item)
                                    <tr>
                                        <td>{{ $item->kode." - ".$item->nama }}</td>
                                        <td>{{ "Rp " . number_format($item->harga_pesan,0,',','.') }}</td>
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

    
</script>
@endsection