<div class="modal fade" id="modalUbahStatus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Status Retur Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form action="" method="POST" id="formUbahStatus">
                @csrf
                @method('PUT')
                <input type="hidden" id="statusReturSebelumnya">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status Retur</p>
                    <div class="col-sm-8">
                      <select class="form-control select2 select2bs4" name="status_retur" id="selectStatusRetur" required>
                          <option value="Menunggu pengajuan dicek admin">Menunggu pengajuan dicek admin</option>
                          <option value="Pengajuan retur diterima admin">{{ "Pengajuan retur diterima admin" }}</option>
                          <option value="Pengajuan retur ditolak admin">{{ "Pengajuan retur ditolak admin" }}</option>
                          <option value="Barang retur telah diterima admin">{{ "Barang retur telah diterima admin" }}</option>
                          <option value="Harap tunggu pengembalian dana dari admin">{{ "Harap tunggu pengembalian dana dari admin" }}</option>
                      </select> 
                    </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnUbahStatusRetur" class="btn btn-primary">Ubah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            </div>
        </div>
    </div>
</div>