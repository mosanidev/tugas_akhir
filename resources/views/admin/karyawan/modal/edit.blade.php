<div class="modal fade" id="modal-ubah-karyawan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Akun Karyawan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="" class="formEdit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nama Depan</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_depan_edit" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nama Belakang</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_belakang_edit" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jenis Kelamin</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="jenis_kelamin_edit" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Telepon</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nomor_telepon_edit" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Lahir</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_lahir_edit" autocomplete="off" id="datepickertgllahiredit" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Email</p>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="email_edit" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Foto</p>
                    <div class="col-sm-8">
                        <input type="file" class="form-control-file" name="foto_edit">
                        <p class="text-danger">* Opsional</p>
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" id="btnUpdate" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
