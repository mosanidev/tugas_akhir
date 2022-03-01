@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-9">
            <div class="px-3 py-4">
                <form method="POST" action="{{route('updateProfil')}}" class="d-inline" enctype="multipart/form-data">
                @csrf
                <h5 class="mb-3"><strong>Profil</strong></h5>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nama</p><p class="d-inline">{{ $profil[0]->nama_depan.' '.$profil[0]->nama_belakang }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Jenis Kelamin</p><p class="d-inline">{{ $profil[0]->jenis_kelamin }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Tanggal Lahir</p><p class="d-inline">{{ $profil[0]->tanggal_lahir }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Email</p><p class="d-inline">{{ $profil[0]->email }}</p><br>
                <p class="d-inline-block mr-5" style="width: 30%; height:15px;">Nomor Telepon</p><p class="d-inline"><input type="tel" value="{{ $profil[0]->nomor_telepon }}" name="nomor_telepon"></p><br>
                <button class="btn btn-info p-2 my-3 mr-3" href="">Simpan</button>
                <button type="button" class="btn btn-info p-2 my-3 d-inline" href="" data-toggle="modal" data-target="#exampleModal">Ubah Password</button>
            </div>
            </div>
            <div class="col-3">
                <div class="my-4">
                    {{-- @php $foto = isset(auth()->user()->foto) ? asset('images/profil/'.auth()->user()->id.'/'.auth()->user()->foto) : 'https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg'; @endphp --}}
                    <img id="img-profil" src="{{ asset(auth()->user()->foto) }}" width="182" height="140" class="mx-auto">

                        <div class="d-none">
                            <input type="file" id="inputGantiFotoProfil" accept=".jpg, .jpeg, .png" name="foto_baru">
                        </div>

                        <button type="button" class="btn btn-block btn-info my-1" style="width: 71%;" id="gantiFotoProfil">Unggah Foto Profil</button>
                    </form>
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

                    <button type="submit" class="btn btn-info btn-block w-50 mx-auto">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    {{-- End Modal --}}

<script src="{{ asset('/adminlte/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
        $('#gantiFotoProfil').on('click', function() {

            $('#inputGantiFotoProfil').click();

        });

        $('#formUpdateFoto').submit(function(){
            valid = true;

            if($("#inputGantiFotoProfil").val() == ''){
                // your error validation action
                valid =  false;
            }
            else{
                return valid

                $('#formUpdateFoto').submit();
            }

        });

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#img-profil').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#inputGantiFotoProfil").change(function(){
            readURL(this);
        });

    

        if("{{ session('success') }}" != "")
        {
            toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
        }
        else if("{{ session('error') }}" != "")
        {
            toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
        }

</script>
@endsection