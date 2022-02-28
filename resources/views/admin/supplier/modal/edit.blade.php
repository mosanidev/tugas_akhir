{{-- Start Modal --}}
<div class="modal fade" id="modalUbahSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Pemasok</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="formUbahSupplier" action="">
            @csrf
            @method("PUT")
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nama</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="text" class="form-control" name="nama" id="ubahNamaSupplierInput" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Jenis</p>
                </div>
                <div class="form-group col-md-8">
                  <select class="form-control" id="ubahJenisSupplierInput" name="jenis">
                    <option value="Perusahaan">Perusahaan</option>
                    <option value="Individu">Individu</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nomor Telepon</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="number" class="form-control" name="nomor_telepon" id="ubahNoTelpSupplierInput" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Alamat</p>
                </div>
                <div class="form-group col-md-8">
                  <textarea colspan="3" class="form-control" name="alamat" id="ubahAlamatSupplierInput" required></textarea>
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