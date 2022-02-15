{{-- Start Modal --}}
<div class="modal fade" id="modalUbahMerek" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Merek Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahMerek" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <p class="col-sm-4 col-form-label">Merek Barang</p>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  name="merek_barang" id="ubahMerekBarangInput" autocomplete="off" required>
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