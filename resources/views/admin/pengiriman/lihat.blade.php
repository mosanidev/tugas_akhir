@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('pengiriman.index') }}" class="btn btn-link text-info"><- Kembali ke daftar pengiriman</a>

    <h3>Detail Pengiriman</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota Pengiriman</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal Penjualan</label>
              <div class="col-sm-10">
                  <p class="mt-2">{{ \Carbon\Carbon::parse($pengiriman[0]->tanggal_penjualan)->isoFormat('D MMMM Y').", jam ".\Carbon\Carbon::parse($pengiriman[0]->tanggal_penjualan)->isoFormat('HH:mm:ss')." WIB" }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal Diserahkan ke Pengirim</label>
              <div class="col-sm-10">
                <p class="mt-2">
                  @if($pengiriman[0]->tanggal_diserahkan_ke_pengirim == null)
                    {{ "-" }}
                  @else 
                    {{ \Carbon\Carbon::parse($pengiriman[0]->tanggal_diserahkan_ke_pengirim)->isoFormat('D MMMM Y').", jam ".\Carbon\Carbon::parse($pengiriman[0]->tanggal_diserahkan_ke_pengirim)->isoFormat('HH:mm:ss')." WIB" }}
                  @endif
                </p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Resi</label>
              <div class="col-sm-10">
                <p class="mt-2">@if($pengiriman[0]->nomor_resi == null) {{ "-" }} @else {{ $pengiriman[0]->nomor_resi }} @endif</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Pengirim</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->nama_shipper }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Jenis Pengiriman</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->jenis_pengiriman }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Estimasi Tiba</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ \Carbon\Carbon::parse($pengiriman[0]->estimasi_tiba)->isoFormat('D MMMM Y').", jam ".\Carbon\Carbon::parse($pengiriman[0]->estimasi_tiba)->isoFormat('HH:mm:ss')." WIB" }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Total Berat Pengiriman</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->total_berat." gram" }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tarif Pengiriman</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ "Rp " . number_format($pengiriman[0]->tarif,0,',','.') }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nama Penerima</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->nama_penerima }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Dikirim ke</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->alamat.", ".$pengiriman[0]->kecamatan.", ".$pengiriman[0]->kota_kabupaten.", ".$pengiriman[0]->provinsi.", ".$pengiriman[0]->kode_pos }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status Pengiriman</label>
              <div class="col-sm-10">
                <p class="mt-2">{{ $pengiriman[0]->status_pengiriman }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Riwayat Pengiriman</label>
              <div class="col-sm-10">

                @if($riwayat_pengiriman != null)
                  @foreach($riwayat_pengiriman->history as $item)
                    <div class="row">
                      <div class="col-3">
                        <p class="mt-2">{{ \Carbon\Carbon::parse($item->updated_at)->isoFormat('D MMMM Y HH:mm') }}</p><br>
                      </div>
                      <div class="col-9">
                          <p class="mt-2">{{ "Paket telah sampai ke tujuan ".$item->note  }}</p><br>
                      </div>
                    </div>
                  @endforeach
                @else 
                    <p class="mt-2">{{ "Belum ada riwayat pengiriman" }}</p>
                @endif
                
              </div>
            </div>
            
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Dikirim : </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Berat</th>
                                    <th>Kuantitas</th>
                                    <th>Subtotal Berat</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                @php $num = 1; @endphp
                                @for($i=0; $i < count($barang); $i++)
                                    <tr>
                                        <td>{{ $barang[$i]->kode." - ".$barang[$i]->nama }}</td>
                                        <td>{{ $barang[$i]->berat." gram"  }}</td>
                                        <td>{{ $barang[$i]->kuantitas  }}</td>
                                        <td>{{ $barang[$i]->berat*$barang[$i]->kuantitas." gram" }}</td>
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