{{-- Start Modal --}}
<div class="modal fade" id="modalUbahBarangDibeli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Barang yang Dibeli</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="formUbah"> 
                @csrf
                @method('PUT')
                <input type="hidden" name="pembelian_id" id="ubahPembelianID" value="{{ $pembelian[0]->id }}"/> 
                <div class="form-group row" id="divUbahBarangDibeli">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8">
                      <select class="form-control select2 select2bs4" name="barang_id" id="selectBarangUbah" required>
                          <option disabled selected>Barang</option>
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-harga="{{ $item->harga_beli }}">{{ $item->nama }}</option>
                          @endforeach
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="hargaBeliUbah" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_beli" step="100" min="500" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas</p>
                    <div class="col-sm-8">
                        <input type="number" id="kuantitasUbah" class="form-control d-inline ml-1" name="kuantitas" min="1" required>
              
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" name="subtotal" class="form-control d-inline ml-1" id="subtotalUbah" style="width: 94.2%;" val="" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnUbahBarangDibeli" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

