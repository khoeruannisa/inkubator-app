<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inkubator</title>
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
        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .login-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 8px;
        }
        .login-title {
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
        .btn-login {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 4px;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; color: white; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-icon">🥚</div>
    <div class="login-title">Login Inkubator</div>

    @if(session('error'))
        <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="admin@inkubator.com"
                value="{{ old('email') }}"
                required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="••••••••"
                required>
        </div>

        <button type="submit" class="btn-login">Masuk →</button>
    </form>

    <p class="text-center mt-3 mb-0 small text-muted">
        Belum punya akun? <a href="/register" class="text-primary fw-bold">Daftar</a>
    </p>
</div>

</body>
</html>