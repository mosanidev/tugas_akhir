@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('back_order.index') }}" class="btn btn-link"><- Kembali ke daftar back order</a>

    <h3>Data Back Order</h3>

    <div class="px-2 py-3">
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota Back Order</label>
              <div class="col-sm-8">
                <p>{{ str_pad($back_order[0]->id, 4, '0', STR_PAD_LEFT)  }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                <div class="col-sm-8">
                  <p>{{ \Carbon\Carbon::parse($back_order[0]->tanggal_pemesanan)->isoFormat('D MMMM Y') }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Terima</label>
                <div class="col-sm-8">
                  <p>{{ \Carbon\Carbon::parse($back_order[0]->tanggal_terima)->isoFormat('D MMMM Y') }}</p> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                  <p>{{ $back_order[0]->nama_supplier }}</p>
                </div>
              </div>
              <div class="form-group row">
                 <label class="col-sm-4 col-form-label">Total</label>
                 <div class="col-sm-8">
                 <p>{{ "Rp " . number_format($back_order[0]->total,0,',','.') }}</p>   
                 </div>
              </div>
            
            Barang yang dipesan : 
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel barang yang dipesan</h6>
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
                            <tbody>
                                @foreach($detail_barang_dipesan as $item)
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

            <br>

            Barang yang belum diterima : 
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel barang yang belum diterima</h6>
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
                            <tbody>
                                @foreach($detail_barang_belum_diterima as $item)
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

    $(document).ready(function() {

    });

</script>
@endsection