<div class="modal fade" id="modal-tambah-karyawan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Karyawan</h4>
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
                    <p class="col-sm-4 col-form-label">Jenis Kelamin</p>
                    <div class="col-sm-8">
                        <select class="form-control" name="jenis_kelamin" required>
                            <option disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">{{ "Laki-laki" }}</option>
                            <option value="Perempuan">{{ "Perempuan" }}</option>
                        </select>   
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Telepon</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nomor_telepon" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Lahir</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_lahir" autocomplete="off" id="datepickertgllahir" required>
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
                        <input type="email" class="form-control" name="email" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Password</p>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Ulangi Password</p>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="re_password" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Foto</p>
                    <div class="col-sm-8">
                        <input type="file" class="form-control-file" name="foto">
                    </div>
                </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->