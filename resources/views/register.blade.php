<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Inkubator Telur Pintar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #059669;
            --primary-hover: #047857;
            --dark: #0f172a;
        }

        * { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }

        body {
            background: radial-gradient(circle at 10% 20%, rgba(5, 150, 105, 0.15) 0%, rgba(0, 0, 0, 0) 40%),
                        radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.12) 0%, rgba(0, 0, 0, 0) 50%),
                        linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 45px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .register-icon-wrapper {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            font-size: 32px;
            color: var(--primary);
            box-shadow: inset 0 2px 4px rgba(255,255,255,0.2);
        }

        .register-title {
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .register-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            z-index: 10;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px 14px 14px 48px;
            border: 1px solid #e2e8f0;
            font-weight: 500;
            color: var(--dark);
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: white;
        }

        .alert {
            border-radius: 14px;
            font-size: 14px;
            padding: 12px 16px;
            border: none;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-icon-wrapper">
        <i class="fa-solid fa-user-plus"></i>
    </div>
    <div class="register-title">Daftar Akun</div>
    <div class="register-subtitle">Buat akun baru untuk mengelola inkubator.</div>

    @if($errors->any())
        <div class="alert alert-danger py-2.5 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-exclamation fs-5"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success py-2.5 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <div class="input-group-custom">
            <i class="fa-solid fa-user"></i>
            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama Lengkap"
                value="{{ old('name') }}"
                required>
            @error('name')
                <div class="invalid-feedback d-block mt-1 ps-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group-custom">
            <i class="fa-solid fa-envelope"></i>
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Alamat Email"
                value="{{ old('email') }}"
                required>
            @error('email')
                <div class="invalid-feedback d-block mt-1 ps-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group-custom" style="margin-bottom: 24px;">
            <i class="fa-solid fa-lock"></i>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Kata Sandi (min. 4 karakter)"
                required>
        </div>

        <button type="submit" class="btn-register">
            Daftar Sekarang <i class="fa-solid fa-arrow-right ms-2"></i>
        </button>
    </form>

    <p class="text-center mt-4 mb-0 small text-secondary fw-medium">
        Sudah punya akun? <a href="/login" class="text-primary fw-bold text-decoration-none">Login</a>
    </p>
</div>

</body>
</html>