<div class="row">
    <div class="col-9">
        <div class="px-3 py-4">
            <form method="POST" action="{{route('updateProfil')}}" class="d-inline">
            @csrf
            <h5 class="mb-3"><strong>Profil</strong></h5>
            <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nama</p><p class="d-inline">{{ $profil[0]->nama }}</p><br>
            <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Jenis Kelamin</p><p class="d-inline">{{ $profil[0]->jenis_kelamin }}</p><br>
            <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Tanggal Lahir</p><p class="d-inline">{{ $profil[0]->tanggal_lahir }}</p><br>
            <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Email</p><p class="d-inline">{{ $profil[0]->email }}</p><br>
            <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nomor Telepon</p><p class="d-inline"><input type="tel" value="{{ $profil[0]->nomor_telepon }}" name="nomor_telepon"></p><br>
            <button class="btn btn-success p-2 my-3 mr-3" href="">Simpan</button>
            </form>
            <button class="btn btn-success p-2 my-3 d-inline" href="" data-toggle="modal" data-target="#exampleModal">Ubah Password</button>
        </div>
        </div>
        <div class="col-3">
            <div class="my-4">
                <img src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" class="img-fluid mx-auto">
                <a class="btn btn-block btn-success mx-auto mt-2" href="">Unggah</a>
            </div>
        </div>
</div>

{{-- Start Modal  --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ route('changePassword') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Password Saat Ini</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" name="new_password" required>
                </div>
                <div class="form-group">
                    <label>Ulangi Password Baru</label>
                    <input type="password" class="form-control" name="re_new_password" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
      </div>
    </div>
</div>
{{-- End Modal --}}
