<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun baru untuk sistem monitoring inkubator telur pintar">
    <title>Daftar Akun — Inkubator Telur Pintar</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --purple-deep:   #1e1b4b;
            --purple-mid:    #3730a3;
            --purple-accent: #7c3aed;
            --purple-light:  #a78bfa;
            --amber:         #f59e0b;
            --amber-glow:    rgba(245,158,11,0.45);
            --white:         #ffffff;
            --slate-50:      #f8fafc;
            --slate-100:     #f1f5f9;
            --slate-200:     #e2e8f0;
            --slate-400:     #94a3b8;
            --slate-600:     #475569;
            --slate-900:     #0f172a;
            --radius-sm:     10px;
            --radius-md:     16px;
            --radius-lg:     22px;
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            display: grid;
            grid-template-columns: 1fr 500px;
            min-height: 100vh;
            background: var(--slate-900);
        }

        /* ══════════════════════════════════════
           HERO PANEL (kiri)
        ══════════════════════════════════════ */
        .hero {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 64px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--purple-deep) 0%, #2e1065 50%, var(--purple-mid) 100%);
        }

        /* Animated orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 {
            width: 440px; height: 440px;
            background: radial-gradient(circle, rgba(139,92,246,0.3), transparent 70%);
            top: -130px; right: -90px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%);
            bottom: -70px; left: -50px;
            animation-delay: -3s;
        }
        .orb-3 {
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(236,72,153,0.2), transparent 70%);
            top: 35%; left: 15%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-18px) scale(1.04); }
        }

        /* Grid dots */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 440px;
        }

        .hero-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 52px;
        }

        .hero-brand-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--amber), #d97706);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.25), 0 8px 24px var(--amber-glow);
            animation: pulse-amber 3s ease-in-out infinite;
        }

        @keyframes pulse-amber {
            0%, 100% { box-shadow: 0 0 0 3px rgba(245,158,11,0.25), 0 8px 24px var(--amber-glow); }
            50% { box-shadow: 0 0 0 6px rgba(245,158,11,0.12), 0 12px 32px var(--amber-glow); }
        }

        .hero-brand-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.1;
            letter-spacing: -0.3px;
        }

        .hero-brand-name small {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0;
        }

        .hero-title {
            font-size: clamp(26px, 3.2vw, 36px);
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            letter-spacing: -0.8px;
            margin-bottom: 14px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #c4b5fd, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 14.5px;
            color: rgba(255,255,255,0.48);
            line-height: 1.7;
            margin-bottom: 44px;
            max-width: 380px;
        }

        /* Steps list */
        .step-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            cursor: default;
        }

        .step-item:last-child { border-bottom: none; }

        .step-num {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            margin-top: 1px;
            transition: all 0.3s ease;
        }

        .step-item:hover .step-num {
            transform: scale(1.1);
        }

        .step-text h6 {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--white);
            margin: 0 0 4px;
        }

        .step-text p {
            font-size: 12px;
            color: rgba(255,255,255,0.44);
            margin: 0;
            line-height: 1.55;
        }

        /* ══════════════════════════════════════
           FORM PANEL (kanan)
        ══════════════════════════════════════ */
        .form-panel {
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 48px;
            overflow-y: auto;
            position: relative;
        }

        /* Top decoration */
        .form-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--purple-accent), #ec4899, var(--amber));
        }

        .form-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f5f3ff;
            color: #5b21b6;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 20px;
            width: fit-content;
        }

        .form-title {
            font-size: clamp(22px, 2.5vw, 27px);
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.7px;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--slate-400);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Alert */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 22px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-box.danger {
            background: #fff1f2;
            color: #9f1239;
            border-left: 4px solid #f43f5e;
        }

        .alert-box.success {
            background: #f0fdf4;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-box i { flex-shrink: 0; margin-top: 1px; }

        /* Input fields */
        .field {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--slate-600);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 9px;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--slate-400);
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .field-input {
            width: 100%;
            padding: 13px 44px 13px 46px;
            border: 2px solid var(--slate-200);
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            color: var(--slate-900);
            background: var(--slate-50);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.22s ease;
            -webkit-appearance: none;
        }

        .field-input::placeholder { color: var(--slate-400); }

        .field-input:focus {
            outline: none;
            border-color: var(--purple-accent);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
        }

        .field-wrap:focus-within .field-icon {
            color: var(--purple-accent);
        }

        .field-input.invalid {
            border-color: #ef4444;
            background: #fff5f5;
        }

        .field-input.invalid:focus {
            box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
        }

        .eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate-400);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s ease;
            font-size: 14px;
        }

        .eye-btn:hover { color: var(--slate-600); }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #ef4444;
            margin-top: 7px;
        }

        .hint-msg {
            font-size: 11.5px;
            color: var(--slate-400);
            margin-top: 7px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Password strength */
        .strength-bar-wrap {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }

        .strength-bar {
            flex: 1;
            height: 3px;
            border-radius: 3px;
            background: var(--slate-200);
            transition: background 0.3s ease;
        }

        .strength-bar.weak   { background: #ef4444; }
        .strength-bar.medium { background: #f59e0b; }
        .strength-bar.strong { background: #22c55e; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 50%, #5b21b6 100%);
            border: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(124,58,237,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(124,58,237,0.45);
        }

        .btn-submit:hover::after { opacity: 1; }
        .btn-submit:active { transform: translateY(0); }

        /* Terms */
        .terms-note {
            font-size: 11.5px;
            color: var(--slate-400);
            text-align: center;
            margin-top: 14px;
            line-height: 1.6;
        }

        /* Divider */
        .or-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 22px 0;
            font-size: 12px;
            color: var(--slate-400);
            font-weight: 600;
        }

        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--slate-200);
        }

        /* Bottom link */
        .bottom-link {
            text-align: center;
            font-size: 14px;
            color: var(--slate-400);
            font-weight: 500;
        }

        .bottom-link a {
            color: var(--purple-accent);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .bottom-link a:hover { color: #6d28d9; text-decoration: underline; }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            background: var(--slate-100);
            color: var(--slate-600);
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 2px solid var(--slate-200);
        }

        .btn-back:hover {
            background: var(--slate-200);
            color: var(--slate-900);
        }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width: 1100px) {
            body { grid-template-columns: 1fr 460px; }
            .hero { padding: 48px; }
        }

        @media (max-width: 900px) {
            body { grid-template-columns: 1fr 420px; }
            .hero { padding: 44px 40px; }
            .form-panel { padding: 44px 36px; }
        }

        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
                min-height: 100vh;
                overflow-y: auto;
            }

            .hero {
                padding: 36px 24px 32px;
                align-items: center;
                text-align: center;
            }

            .hero-brand { justify-content: center; margin-bottom: 24px; }
            .hero-subtitle { font-size: 13px; margin-bottom: 0; max-width: 100%; }
            .step-list { display: none; }

            .form-panel { padding: 40px 24px 52px; }
        }

        @media (max-width: 480px) {
            .hero { padding: 28px 18px 24px; }
            .hero-title { font-size: 21px; }
            .hero-brand-name { font-size: 17px; }

            .form-panel { padding: 32px 18px 48px; }
            .form-title { font-size: 21px; }

            .btn-submit { padding: 14px; font-size: 14px; }
        }

        @media (max-width: 360px) {
            .hero { padding: 22px 14px 18px; }
            .form-panel { padding: 26px 14px 44px; }
        }
    </style>
</head>
<body>

<!-- ══════ HERO PANEL ══════ -->
<div class="hero">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="hero-content">
        <div class="hero-brand">
            <div class="hero-brand-icon">
                <i class="fa-solid fa-egg"></i>
            </div>
            <div class="hero-brand-name">
                Inkubator Pintar
                <small>Sistem Pemantauan Telur</small>
            </div>
        </div>

        <h1 class="hero-title">
            Mulai Pantau<br>
            <span>Inkubator Anda 🥚</span>
        </h1>
        <p class="hero-subtitle">
            Daftar sekarang dan kendalikan inkubator telur Anda dari mana saja dengan sistem monitoring otomatis yang cerdas.
        </p>

        <div class="step-list">
            <div class="step-item">
                <div class="step-num" style="background:rgba(167,139,250,0.15);color:#c4b5fd;">01</div>
                <div class="step-text">
                    <h6>Buat Akun Gratis</h6>
                    <p>Isi nama, email, dan kata sandi untuk memulai — hanya 30 detik.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num" style="background:rgba(52,211,153,0.15);color:#6ee7b7;">02</div>
                <div class="step-text">
                    <h6>Hubungkan Perangkat</h6>
                    <p>Perangkat ESP8266 akan mengirim data sensor secara otomatis.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num" style="background:rgba(251,191,36,0.15);color:#fde68a;">03</div>
                <div class="step-text">
                    <h6>Pantau & Nikmati</h6>
                    <p>Lihat grafik real-time, atur parameter, dan biarkan sistem bekerja otomatis.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ══════ FORM PANEL ══════ -->
<div class="form-panel">

    <div class="form-badge">
        <i class="fa-solid fa-user-plus"></i> Buat Akun Baru
    </div>
    <h2 class="form-title">Daftar Sekarang</h2>
    <p class="form-subtitle">Isi data di bawah untuk membuat akun dan mulai memantau inkubator Anda.</p>

    @if($errors->any())
        <div class="alert-box danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-box success">
            <i class="fa-solid fa-circle-check"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form method="POST" action="/register" id="registerForm">
        @csrf

        <div class="field">
            <label class="field-label" for="name">Nama Lengkap</label>
            <div class="field-wrap">
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="field-input @error('name') invalid @enderror"
                    placeholder="Masukkan nama lengkap Anda"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    required>
                <i class="fa-solid fa-user field-icon"></i>
            </div>
            @error('name')
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="field">
            <label class="field-label" for="email">Alamat Email</label>
            <div class="field-wrap">
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="field-input @error('email') invalid @enderror"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required>
                <i class="fa-solid fa-envelope field-icon"></i>
            </div>
            @error('email')
                <div class="error-msg">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <div class="field" style="margin-bottom:24px;">
            <label class="field-label" for="password">Kata Sandi</label>
            <div class="field-wrap">
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="field-input"
                    placeholder="Minimal 4 karakter"
                    autocomplete="new-password"
                    required>
                <i class="fa-solid fa-lock field-icon"></i>
                <button type="button" class="eye-btn" id="togglePwd" aria-label="Tampilkan kata sandi">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <!-- Password strength indicator -->
            <div class="strength-bar-wrap" id="strengthBars">
                <div class="strength-bar" id="bar1"></div>
                <div class="strength-bar" id="bar2"></div>
                <div class="strength-bar" id="bar3"></div>
                <div class="strength-bar" id="bar4"></div>
            </div>
            <div class="hint-msg" id="strengthLabel">
                <i class="fa-solid fa-info-circle"></i>
                <span>Gunakan kombinasi huruf dan angka</span>
            </div>
        </div>

        <button type="submit" class="btn-submit" id="registerBtn">
            <i class="fa-solid fa-rocket"></i>
            Buat Akun Sekarang
        </button>

        <p class="terms-note">
            Dengan mendaftar, Anda menyetujui penggunaan data untuk keperluan monitoring inkubator.
        </p>
    </form>

    <div class="or-divider">atau</div>

    <div class="bottom-link">
        @auth
            <a href="/dashboard" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>Kembali ke Dashboard
            </a>
        @else
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        @endauth
    </div>
</div>

<script>
    // ─── Toggle password visibility
    const togglePwd = document.getElementById('togglePwd');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    togglePwd.addEventListener('click', () => {
        const isHidden = pwdInput.type === 'password';
        pwdInput.type  = isHidden ? 'text' : 'password';
        eyeIcon.className = isHidden ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });

    // ─── Password strength meter
    const bars   = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
    const label  = document.getElementById('strengthLabel').querySelector('span');

    pwdInput.addEventListener('input', () => {
        const val = pwdInput.value;
        let score = 0;

        if (val.length >= 4)  score++;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val) || /[0-9]/.test(val)) score++;
        if (/[!@#$%^&*]/.test(val)) score++;

        const colors = ['', 'weak', 'medium', 'medium', 'strong'];
        const labels = ['Gunakan kombinasi huruf dan angka', 'Lemah — tambah karakter lagi', 'Cukup — bisa lebih kuat', 'Kuat', 'Sangat Kuat! 💪'];

        bars.forEach((bar, i) => {
            bar.className = 'strength-bar ' + (i < score ? colors[score] : '');
        });

        label.textContent = val.length ? labels[score] : 'Gunakan kombinasi huruf dan angka';
    });

    // ─── Loading state on submit
    document.getElementById('registerForm').addEventListener('submit', function() {
        const btn = document.getElementById('registerBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btn.disabled = true;
    });
</script>

</body>
</html>