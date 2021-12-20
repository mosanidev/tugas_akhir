{{-- Start Modal --}}
<div class="modal fade" id="modalUbahKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Kategori Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahKategori" method="POST" action="">
            @csrf
            @method('PUT')
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Kategori Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="kategori_barang" id="ubahKategoriBarangInput">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- End Modal --}}