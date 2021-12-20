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
    <title>Toko Kopkar UBAYA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <div class="mx-auto w-50">
            <ul class="navbar-nav d-inline-block">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link active mr-3"><i class="fas fa-arrow-left"></i></a>
                </li>
            </ul>
    
            <p class="h5 mt-2 d-inline-block" style="margin: 0px 38%;"><b>Daftar</b></p>

        </div>
    </nav>

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

    <div class="bg-light m-5 p-4 w-50 mx-auto border">
        <form method="POST" action="{{ route('pelanggan.register') }}">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" name="nama_depan" placeholder="Masukkan nama depan" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="nama_belakang" placeholder="Masukkan nama belakang" required>
            </div>
            <div class="mb-3">
                <select class="form-control" name="jenis_kelamin" required>
                    <option value="" disabled selected>Pilih jenis kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                {{-- <input placeholder="Pilih tanggal lahir" type="date" class="form-control"> --}}
                <input type="text" placeholder="Pilih tanggal lahir" name="tanggal_lahir" id="tgl" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="tel" class="form-control" name="nomor_telepon" placeholder="Masukkan nomor telepon" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="re_password" placeholder="Ulangi password" required>
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" name="nomor_anggota" placeholder="Masukkan nomor anggota">
                <p class="text-danger" style="font-size: 1rem">* Khusus untuk anggota Koperasi Karyawan Universitas Surabaya</p>
            </div>
            <button type="submit" class="btn btn-block btn-success w-25 mx-auto">Submit</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#tgl").datepicker({
            format: 'yyyy-mm-dd',
        });

        $("#alert-close").click(function() {
            $("#alert").hide();
        });
    </script>

</body>
</html>