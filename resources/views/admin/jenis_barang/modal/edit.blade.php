{{-- Start Modal --}}
<div class="modal fade" id="modalUbahJenis" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Jenis Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahJenis" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-group row">
              <p class="col-sm-4 col-form-label">Jenis Barang</p>
              <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenis_barang" autocomplete="off" id="ubahJenisBarangInput" required>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- End Modal --}}