@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('penjualanoffline.index') }}" class="btn btn-link"><- Kembali ke daftar penjualan offline</a>

    <h3 class="mt-3 mb-2 ml-3">Tambah Penjualan Offline</h3>

    <div class="container-fluid">
        <div class="p-3">
            <input type="hidden" id="dataBarangDijual" name="detail_penjualan">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                    <p>{{ $penjualan_offline[0]->nomor_nota }}</p> 
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                    <p>{{ $penjualan_offline[0]->tanggal }}</p>  
                </div>
            </div> 
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pelanggan</label>
                <div class="col-sm-8">
                    @if($penjualan_offline[0]->users_id == null)
                        <p>{{ "Non anggota koperasi" }}</p>
                    @else
                        <p>{{ "Anggota koperasi : ".$penjualan_offline[0]->nama_depan." ".$penjualan_offline[0]->nama_belakang }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                    <p>{{ $penjualan_offline[0]->metode_pembayaran }}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <p>{{ "Rp ". number_format($penjualan_offline[0]->total,0,',','.') }}</p>
                </div>
            </div>

            @if($penjualan_offline[0]->status_retur == "Ada Retur")
                <p>{{ "Penjualan ini telah diretur oleh pelanggan" }}</p>
            @endif

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Tanggal Kadaluarsa</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>Kuantitas</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail_penjualan_offline as $item)
                                    <tr>
                                        <td>{{ $item->kode." - ".$item->nama }}</td>
                                        <td>{{ $item->tanggal_kadaluarsa }}</td>
                                        <td>{{ "Rp " . number_format($item->harga_jual,0,',','.') }}</td>
                                        <td>{{ "Rp " . number_format($item->diskon_potongan_harga,0,',','.') }}</td>
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
    </div>


    <script type="text/javascript">
    
    
    </script>


@endsection