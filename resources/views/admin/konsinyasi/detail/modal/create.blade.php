{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangKonsinyasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Konsinyasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('barangkonsinyasi.store') }}" id="formTambah">
                @csrf
                <input type="hidden" value="" name="konsinyasi_id" id="konsinyasi_id">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Barang</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="barang_id" id="selectBarangKonsinyasi" required>
                      <option disabled selected>Barang</option>
                      @foreach($barang as $item)
                          <option value="{{ $item->id }}">{{$item->nama}}</option>
                      @endforeach
                  </select>                  
                 </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Jumlah Titip</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="jumlah_titip" min="1" id="inputJumlahTitip" required>
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
                <div class="modal-footer">
                  <button type="button" id="btnTambahBarangKonsinyasi" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
