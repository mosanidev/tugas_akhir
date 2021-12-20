{{-- Start Modal --}}
<div class="modal fade" id="modalUbahPembelian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="formUbah">
                @csrf
                @method('PUT')
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor Nota</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nomor_nota" id="inputNomorNotaUbah" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTglUbah" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Supplier</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="supplier_id" id="selectSupplierUbah" required>
                        <option disabled selected>Supplier</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->id }}">{{$item->nama}}</option>
                        @endforeach
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Konsinyasi</label>
                  <div class="col-sm-10">
                    <div class="checkbox">
                        <label><input type="checkbox" class="mr-2" name="konsinyasi" value="ya" id="checkKonsinyasiUbah">Ya, pembelian menggunakan sistem konsinyasi</label>
                    </div>
                  </div>
                </div>
            <div class="modal-footer">
              <button type="submit" id="btnUbahPembelian" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>
