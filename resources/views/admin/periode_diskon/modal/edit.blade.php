{{-- Start Modal --}}
<div class="modal" id="modalUbahPeriodeDiskon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Periode Diskon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="form-ubah" action="" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Nama</p>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required>
                  </div>
              </div>
              <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Tanggal Dimulai</p>
                  <div class="col-sm-8">
                      <div class="form-group">
                          <div class="input-group">
                              <input type="text" class="form-control pull-right" name="tanggal_dimulai" autocomplete="off" id="datepickerubahtglawal" required>
                              <div class="input-group-append">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>                
                  </div>
              </div>
              <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Tanggal Berakhir</p>
                  <div class="col-sm-8">
                      <div class="form-group">
                          <div class="input-group">
                              <input type="text" class="form-control pull-right" name="tanggal_berakhir" autocomplete="off" id="datepickerubahtglakhir" required>
                              <div class="input-group-append">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>                
                  </div>
              </div>
              <div class="form-group row">
                <p class="col-sm-4 col-form-label">Status</p>
                <div class="col-sm-8">
                    <div class="form-group">
                      <select id="status" name="status" class="form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                      </select>
                    </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
      </form>
      </div>
    </div>
  </div>
  {{-- End Modal --}}