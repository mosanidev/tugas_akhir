{{-- Start Modal --}}
<div class="modal fade" id="modalTambahPembelian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pembelian.store') }}">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor Nota</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggalBuat" autocomplete="off" id="datepickerTgl" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggalJatuhTempo" autocomplete="off" id="datepickerTglJatuhTempo" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Supplier</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="supplier_id" id="selectSupplier" required>
                        <option disabled selected>Supplier</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->id }}">{{$item->nama}}</option>
                        @endforeach
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
