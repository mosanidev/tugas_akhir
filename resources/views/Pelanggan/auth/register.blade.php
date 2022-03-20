<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost:8000/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">
    <title>Toko Kopkar UBAYA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light justify-content-center bg-warning py-2">
        <div class="container">
            <div class="col text-right">
                <ul class="navbar-nav d-inline-block">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link active mr-3"><i class="fas fa-arrow-left"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <p class="h5 mt-2 text-center"><b>Daftar</b></p>
            </div>
            <div class="col">

            </div>
        </div>
    </nav>

    {{-- <nav class="navbar navbar-expand-lg navbar-light justify-content-center bg-warning py-2">
        <p class="h5 mt-2 d-inline-block"><b>Daftar</b></p>
    </nav> --}}

    @if(session('errors'))
        <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="text-center"><strong>Terjadi kesalahan:</strong></p>
            <button id="alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <ul>
            @foreach ($errors->all() as $error)
            <li class="w-50 mx-auto">{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">
            <p class="text-center">{{ Session::get('success') }}</p>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <p class="text-center">{{ Session::get('error') }}</p>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col col-sm-2"></div>
            <div class="col-12 col-sm-8 bg-light my-5 py-4 border">
                <form method="POST" action="{{ route('pelanggan.register') }}" id="formRegister">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nama_depan" id="nama_depan" placeholder="Masukkan nama depan" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nama_belakang" id="nama_belakang" placeholder="Masukkan nama belakang" required>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        {{-- <input placeholder="Pilih tanggal lahir" type="date" class="form-control"> --}}
                        <input type="text" placeholder="Pilih tanggal lahir" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" name="nomor_telepon" id="nomor_telepon" min="10" placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" id="password" min="8" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Ulangi password" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" class="form-control" name="nomor_anggota" id="nomor_anggota" placeholder="Masukkan nomor anggota Koperasi Karyawan Universitas Surabaya">
                        <p class="text-danger" style="font-size: 1rem">* Kosongi jika anda bukan anggota Koperasi Karyawan Universitas Surabaya</p>
                    </div>
                    <button type="button" id="btnRegister" class="btn btn-block btn-success w-25 mx-auto">Daftar</button>
                </form>
            </div>
            <div class="col col-sm-2"></div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/scripts/helper.js') }}"></script>

    <script>
        $("#tanggal_lahir").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $("#alert-close").click(function() {
            $("#alert").hide();
        });

        let arrNIKanggota = ['160416154', '160416054', '160416101', '160416443'];

        $('#btnRegister').on('click', function() {

            let cariNIKYangSama = false;

            $('#btnRegister').attr('type', 'button');

            if($('#nama_depan').val() == "")
            {
                toastr.error("Harap isi nama depan terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#nama_belakang').val() == "")
            {
                toastr.error("Harap isi nama belakang terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#jenis_kelamin')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih jenis kelamin terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#tanggal_lahir').val() == "")
            {
                toastr.error("Harap isi tanggal lahir terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#nomor_telepon').val() == "")
            {
                toastr.error("Harap isi nomor telepon terlebih dahulu", "Error", toastrOptions);

            }
            else if ($('#email').val() == "")
            {
                toastr.error("Harap isi email terlebih dahulu", "Error", toastrOptions);

            }
            else if ($('#password').val() == "")
            {
                toastr.error("Harap isi password terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#re_password').val() == "")
            {
                toastr.error("Harap ulangi password terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#password').val() != $('#re_password').val())
            {
                toastr.error("Harap ketikkan ulang password dengan benar", "Error", toastrOptions);
            }
            else if ($('#nomor_anggota').val() != "")
            {
                for(let i = 0; i < arrNIKanggota.length; i++)
                {
                    if($('#nomor_anggota').val() == arrNIKanggota[i])
                    {
                        cariNIKYangSama = true
                        break;
                    }
                }

                if(!cariNIKYangSama)
                {
                    toastr.error("Nomor anggota tidak ditemukan", "Error", toastrOptions);
                }
                else // inputan nik ada yang sama
                {
                    $('#btnRegister').attr('type', 'submit');
                    $('#btnRegister')[0].click();
                }
            }
            else 
            {
                $('#btnRegister').attr('type', 'submit');
                $('#btnRegister')[0].click();
            }



        });
    </script>

</body>
</html>