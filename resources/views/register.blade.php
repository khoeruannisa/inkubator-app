<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4">

        <h4>Register</h4>

        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <button class="btn btn-success w-100">Daftar</button>
        </form>

        <p class="mt-2">
            Sudah punya akun? <a href="/login">Login</a>
        </p>

    </div>
</div>

</body>
</html>