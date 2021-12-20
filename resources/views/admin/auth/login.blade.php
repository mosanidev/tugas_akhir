<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Admin | Login</title>

    <style>

        /* form {
            margin: auto;
            width: 50%;
            padding: 10px;
        } */

    </style>

</head>
<body>
    <nav class="bg-primary">
        <p class="h5 text-center p-3 text-light">ADMIN LOGIN</p>
    </nav>

    <div class="border border-primary mt-5 p-3 w-50 mx-auto">
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan password" minlength="8" required>
            </div>
            <button type="submit" class="btn btn-block btn-primary w-25 mx-auto">Masuk</button>
        </form>
    </div>
    <script>
        console.log("{{ session('error') }}")
    </script>
</body>
</html>