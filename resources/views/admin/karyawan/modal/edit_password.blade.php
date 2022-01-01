<div class="modal fade" id="modal-ubah-password-karyawan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Password Akun Karyawan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="" id="formEditPassword" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Password</p>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password_change" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Ulangi Password</p>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="re_password_change" autocomplete="off" required>
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" id="btnUpdatePassword" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
