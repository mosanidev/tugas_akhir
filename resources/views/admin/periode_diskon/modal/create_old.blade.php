{{-- Start Modal --}}
<div class="modal" id="modalTambahPeriodeDiskon" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Periode Diskon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('periode_diskon.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Nama</p>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama" autocomplete="off" required>
                  </div>
              </div>
              <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Tanggal Dimulai</p>
                  <div class="col-sm-8">
                      <div class="form-group">
                          <div class="input-group">
                              <input type="text" class="form-control pull-right" name="tanggal_dimulai" autocomplete="off" id="datepickertglawal" readonly>
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
                              <input type="text" class="form-control pull-right" name="tanggal_berakhir" autocomplete="off" id="datepickertglakhir" required>
                              <div class="input-group-append">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
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