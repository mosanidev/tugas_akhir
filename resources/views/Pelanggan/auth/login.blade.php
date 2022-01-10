<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">

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
    
            <p class="h5 mt-2 d-inline-block" style="margin: 0px 38%;"><b>Masuk</b></p>

        </div>
    </nav>

    {{-- @if(session('errors'))
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
    @endif --}}

    <div class="bg-light m-5 p-4 w-50 mx-auto border">
        <form method="POST" action="{{ route('pelanggan.login') }}">
            @csrf
            <div class="mb-3">
                <input type="email" class="form-control" aria-describedby="emailHelp" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-block btn-success w-25 mx-auto">Submit</button>
        </form>

        <p class="mt-4 text-center">Belum punya akun? silahkan buat dulu <a href="{{ route('pelanggan.register') }}">disini</a></p>

    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/scripts/helper.js') }}"></script>
<script type="text/javascript">

    if("{{ session('success') }}" != "")
    {
        toastr.success("{{ session('success') }}", "Success", toastrOptions);
    } 
    else if ("{{ session('error') }}" != "")
    {
        toastr.error("{{ session('error') }}", "Error", toastrOptions);
    }

</script>
</body>
</html>