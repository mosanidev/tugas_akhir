{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangRetur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Retur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <form method="POST" action="{{ route('barang_diskon.store') }}" enctype="multipart/form-data"> --}}
                {{-- @csrf --}}
                {{-- <input type="hidden" name="periode_diskon_id" value="{{ $periode_diskon[0]->id }}"/> --}}
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8">
                      <select class="form-control select2 select2bs4" name="barangRetur" id="selectBarangRetur" required>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        <p id="harga_beli"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Retur</p>
                    <div class="col-sm-8">
                        <input type="number" name="jumlah_retur" id="jumlah_retur" class="form-control d-inline mr-2" style="width: 50%;"><p class="d-inline" id="kuantitas"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <p id="subtotal"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahBarangDibeli" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
