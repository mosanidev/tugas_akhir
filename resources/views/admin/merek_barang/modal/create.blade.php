{{-- Start Modal --}}
<div class="modal fade" id="modalTambahMerek" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Merek Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('admin/barang/merek') }}">
            @csrf
            <div class="form-group row">
                <p class="col-sm-4 col-form-label">Merek Barang</p>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="merek_barang" autocomplete="off" required>
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