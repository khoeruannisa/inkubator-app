<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Inkubator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #0f172a, #1e3a5f, #1e293b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .register-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 8px;
        }
        .register-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
        }
        .btn-register {
            background: linear-gradient(135deg, #059669, #34d399);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 4px;
            transition: opacity 0.2s;
        }
        .btn-register:hover { opacity: 0.9; color: white; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-icon">📝</div>
    <div class="register-title">Daftar Akun</div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-bold">Nama Lengkap</label>
            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama Lengkap"
                value="{{ old('name') }}"
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="email@contoh.com"
                value="{{ old('email') }}"
                required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold">Password (min. 4 karakter)</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="••••••••"
                required>
        </div>

        <button type="submit" class="btn-register">Daftar →</button>
    </form>

    <p class="text-center mt-3 mb-0 small text-muted">
        Sudah punya akun? <a href="/login" class="text-primary fw-bold">Login</a>
    </p>
</div>

</body>
</html>