@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pemesanan.index') }}" class="btn btn-link"><- Kembali ke daftar pemesanan</a>

    <h3>Tambah Pemesanan</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor nota</label>
              <div class="col-sm-8">
                <p>{{ $pemesanan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal pemesanan</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->tanggal }}</p>  
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal perkiraan diterima</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->perkiraan_tanggal_terima }}</p>   
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal jatuh tempo bayar</label>
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
                <label class="col-sm-4 col-form-label">Metode pembayaran</label>
                <div class="col-sm-8">
                    <p>{{ $pemesanan[0]->metode_pembayaran }}</p>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon potongan harga</label>
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
                <label class="col-sm-4 col-form-label">Status bayar</label>
                <div class="col-sm-8">
                  <p>{{ $pemesanan[0]->status_bayar }}</p>
                </div>
            </div>

            
            @if($pemesanan[0]->status_bayar == "Lunas sebagian")

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_belum_dibayar+$pemesanan[0]->total_sudah_dibayar,0,',','.') }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total (dikurangi diskon & ppn)</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_belum_dibayar-$pemesanan[0]->diskon-$pemesanan[0]->ppn+$pemesanan[0]->total_sudah_dibayar,0,',','.') }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total sudah dibayar</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_sudah_dibayar,0,',','.') }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Sisa belum dibayar</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_belum_dibayar-$pemesanan[0]->diskon-$pemesanan[0]->ppn,0,',','.') }}</p>
                    </div>
                </div>

            @else 

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_belum_dibayar,0,',','.') }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total (dikurangi diskon & ppn)</label>
                    <div class="col-sm-8">
                        <p>{{ "Rp " . number_format($pemesanan[0]->total_belum_dibayar-$pemesanan[0]->diskon-$pemesanan[0]->ppn,0,',','.') }}</p>
                    </div>
                </div>

            @endif

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