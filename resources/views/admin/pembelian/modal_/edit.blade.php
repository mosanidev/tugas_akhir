{{-- Start Modal --}}
<div class="modal fade" id="modalUbahBarangDibeli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Barang Diskon</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <form method="POST" action="{{ route('barang_diskon.store') }}" enctype="multipart/form-data"> --}}
                {{-- @csrf --}}
                <input type="hidden" id="barangIndex" value=""/>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8">
                      <select class="form-control select2bs4" name="barang" id="barangUbah" required>
                          <option disabled selected>Barang</option>
                          @foreach($barang as $item)
                              <option value="{{ $item->id."-".$item->nama }}">{{$item->nama}}</option>
                          @endforeach
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="hargaBeliUbah" class="form-control d-inline ml-1 numberUbah" style="width: 94.2%;" name="harga_beli" step="100" min="500" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="kuantitasUbah" class="form-control d-inline ml-1 numberUbah" style="width: 94.2%;" name="potongan_harga" min="1" required>
              
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <p id="subtotalUbah"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnUbahBarangDibeli" class="btn btn-primary">Ubah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>