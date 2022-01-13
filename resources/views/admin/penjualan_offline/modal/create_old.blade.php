{{-- Start Modal --}}
<div class="modal fade" id="modalTambahPenjualanOffline" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Penjualan Offline</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('penjualanoffline.store') }}">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor Nota</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTgl" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Anggota Koperasi</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="supplier_id" id="selectNIKPelanggan" required>
                        <option disabled selected>Ketikkan NIK atau nama anggota koperasi</option>
                        {{-- @foreach($supplier as $item)
                            <option value="{{ $item->id }}">{{$item->nama}}</option>
                        @endforeach --}}
                    </select> 
                    <p class="text-danger">* Biarkan tidak dipilih jika pembeli bukan anggota kopkar</p>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="metodePembayaran" id="selectMetodePembayaran" required>
                        <option disabled selected>Metode Pembayaran</option>
                        {{-- <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Tunai">Tunai</option> --}}
                    </select> 
                  </div>
                </div>
                

                <div class="modal-footer">
                <button type="button" id="btnTambahPembelian" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
