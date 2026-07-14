<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Inkubator Telur Pintar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px 16px;
            background: #080d1a;
            position: relative;
            overflow-y: auto;
        }

        /* ── BACKGROUND ── */
        .bg-mesh {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 70% 55% at 15% 10%, rgba(79,70,229,.32) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 85% 85%, rgba(6,182,212,.24) 0%, transparent 55%),
                radial-gradient(ellipse 45% 40% at 50% 50%, rgba(245,158,11,.1) 0%, transparent 55%),
                radial-gradient(ellipse 60% 55% at 10% 88%, rgba(236,72,153,.16) 0%, transparent 55%),
                linear-gradient(155deg, #080d1a 0%, #0f172a 60%, #0a1020 100%);
        }

        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.022) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(72px); opacity: .55;
            animation: drift linear infinite; z-index: 0;
            pointer-events: none;
        }
        .orb-1 { width:480px;height:480px;background:rgba(79,70,229,.28);top:-140px;left:-90px;animation-duration:20s; }
        .orb-2 { width:380px;height:380px;background:rgba(6,182,212,.22);bottom:-90px;right:-70px;animation-duration:24s;animation-delay:-8s; }
        .orb-3 { width:280px;height:280px;background:rgba(245,158,11,.16);top:38%;right:8%;animation-duration:16s;animation-delay:-12s; }

        @keyframes drift {
            0%,100% { transform:translate(0,0) scale(1); }
            33%      { transform:translate(25px,-18px) scale(1.04); }
            66%      { transform:translate(-18px,25px) scale(.96); }
        }

        /* ── CARD ── */
        .card {
            position: relative; z-index: 10;
            width: 100%; max-width: 380px;
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 24px;
            padding: 36px 32px 32px;
            box-shadow: 0 0 0 1px rgba(255,255,255,.04) inset, 0 40px 80px rgba(0,0,0,.55), 0 0 50px rgba(79,70,229,.1);
            animation: cardIn .55s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(28px) scale(.96); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }
        .card::before {
            content:''; position:absolute;
            top:0; left:44px; right:44px; height:2px;
            background:linear-gradient(90deg,transparent,rgba(99,102,241,.85),rgba(6,182,212,.85),transparent);
        }

        /* ── BRAND ── */
        .brand {
            display:flex; flex-direction:column;
            align-items:center; margin-bottom:30px;
        }
        .brand-icon {
            width:62px; height:62px;
            background:linear-gradient(135deg,#4f46e5,#06b6d4);
            border-radius:19px;
            display:flex; align-items:center; justify-content:center;
            font-size:25px; color:#fff; margin-bottom:14px;
            box-shadow:0 0 0 5px rgba(79,70,229,.18), 0 12px 30px rgba(79,70,229,.45);
            animation:pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow:0 0 0 5px rgba(79,70,229,.18),0 12px 30px rgba(79,70,229,.45); }
            50%      { box-shadow:0 0 0 9px rgba(79,70,229,.09),0 16px 38px rgba(79,70,229,.55); }
        }
        .brand-name { font-size:21px;font-weight:800;color:#fff;letter-spacing:-.4px;margin-bottom:4px; }
        .brand-sub  { font-size:12.5px;color:rgba(255,255,255,.38);font-weight:500; }

        /* ── FORM HEADING ── */
        .fhead { text-align:center; margin-bottom:26px; }
        .fhead h2 { font-size:18.5px;font-weight:800;color:#f1f5f9;letter-spacing:-.3px;margin-bottom:5px; }
        .fhead p  { font-size:13px;color:rgba(255,255,255,.38); }

        /* ── ALERTS ── */
        .alert {
            display:flex; align-items:flex-start; gap:10px;
            padding:12px 15px; border-radius:12px;
            font-size:13px; font-weight:500;
            margin-bottom:18px;
            animation:slideDown .3s ease;
        }
        @keyframes slideDown {
            from{opacity:0;transform:translateY(-6px)}
            to{opacity:1;transform:translateY(0)}
        }
        .alert i { flex-shrink:0; margin-top:1px; }
        .alert-danger  { background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.22);color:#fca5a5; }
        .alert-success { background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.22);color:#86efac; }

        /* ── FIELDS ── */
        .field { margin-bottom:16px; }
        .field-label {
            display:block; font-size:11px; font-weight:700;
            color:rgba(255,255,255,.45); text-transform:uppercase;
            letter-spacing:.08em; margin-bottom:8px;
        }
        .field-wrap { position:relative; }
        .field-input {
            width:100%; padding:13px 14px 13px 44px;
            background:rgba(255,255,255,.06);
            border:1.5px solid rgba(255,255,255,.09);
            border-radius:13px; font-size:14.5px; font-weight:500;
            color:#f1f5f9; font-family:'Plus Jakarta Sans',sans-serif;
            transition:all .22s ease; -webkit-appearance:none;
        }
        .field-input::placeholder { color:rgba(255,255,255,.2); }
        .field-input:focus {
            outline:none;
            background:rgba(255,255,255,.09);
            border-color:rgba(99,102,241,.75);
            box-shadow:0 0 0 4px rgba(99,102,241,.14);
        }
        .field-input.has-eye { padding-right:44px; }
        .field-input.invalid { border-color:rgba(239,68,68,.55); background:rgba(239,68,68,.07); }
        .field-input.invalid:focus { box-shadow:0 0 0 4px rgba(239,68,68,.12); }

        .field-icon {
            position:absolute; left:14px; top:50%; transform:translateY(-50%);
            font-size:14px; color:rgba(255,255,255,.28); pointer-events:none;
            transition:color .2s;
        }
        .field-wrap:focus-within .field-icon { color:rgba(99,102,241,.9); }

        .eye-btn {
            position:absolute; right:13px; top:50%; transform:translateY(-50%);
            background:none; border:none; color:rgba(255,255,255,.28);
            cursor:pointer; padding:4px; border-radius:6px; font-size:13.5px;
            transition:color .2s; line-height:1;
        }
        .eye-btn:hover { color:rgba(255,255,255,.65); }

        .error-msg {
            display:flex; align-items:center; gap:5px;
            font-size:11.5px; color:#fca5a5; margin-top:6px;
        }

        /* ── BUTTON ── */
        .btn-submit {
            width:100%; padding:14.5px; margin-top:8px;
            background:linear-gradient(135deg,#4f46e5,#4338ca 55%,#3730a3);
            border:none; border-radius:13px;
            font-size:14.5px; font-weight:700; color:#fff;
            cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;
            transition:all .28s ease;
            box-shadow:0 6px 22px rgba(79,70,229,.45);
            display:flex; align-items:center; justify-content:center; gap:9px;
            position:relative; overflow:hidden;
        }
        .btn-submit::before {
            content:''; position:absolute; inset:0;
            background:linear-gradient(135deg,rgba(255,255,255,.12),transparent 55%);
        }
        .btn-submit:hover { transform:translateY(-2px); box-shadow:0 12px 30px rgba(79,70,229,.58); }
        .btn-submit:active { transform:translateY(0); }

        /* ── DIVIDER + LINK ── */
        .divider {
            display:flex; align-items:center; gap:12px;
            margin:22px 0; font-size:12px; color:rgba(255,255,255,.18); font-weight:600;
        }
        .divider::before,.divider::after { content:'';flex:1;height:1px;background:rgba(255,255,255,.07); }

        .bottom-link { text-align:center; font-size:13.5px; color:rgba(255,255,255,.38); font-weight:500; }
        .bottom-link a { color:#818cf8; font-weight:700; text-decoration:none; transition:color .2s; }
        .bottom-link a:hover { color:#a5b4fc; }

        .security {
            display:flex; align-items:center; justify-content:center; gap:6px;
            font-size:11px; color:rgba(255,255,255,.18); margin-top:18px;
        }

        /* ── RESPONSIVE ── */
        @media(max-width:480px) {
            .card { padding:28px 20px 26px; border-radius:20px; }
            .brand-icon { width:50px;height:50px;font-size:20px; }
            .brand-name { font-size:18px; }
        }
        @media(max-width:360px) {
            .card { padding:22px 14px 22px; border-radius:16px; }
        }
    </style>
</head>
<body>

<div class="bg-mesh"></div>
<div class="bg-grid"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="card">
    <div class="brand">
        <div class="brand-icon"><i class="fa-solid fa-egg"></i></div>
        <div class="brand-name">Inkubator Pintar</div>
        <div class="brand-sub">Sistem Pemantauan Telur Otomatis</div>
    </div>

    <div class="fhead">
        <h2>Selamat Datang Kembali 👋</h2>
        <p>Masuk untuk memantau inkubator Anda secara real-time</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i><span>{{ session('error') }}</span></div>
    @endif
    @if(session('success'))
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif

    <form method="POST" action="/login" id="loginForm">
        @csrf

        <div class="field">
            <label class="field-label" for="email">Alamat Email</label>
            <div class="field-wrap">
                <input id="email" type="email" name="email"
                    class="field-input @error('email') invalid @enderror"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}"
                    autocomplete="email" required>
                <i class="fa-solid fa-envelope field-icon"></i>
            </div>
            @error('email')
                <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="field" style="margin-bottom:24px;">
            <label class="field-label" for="password">Kata Sandi</label>
            <div class="field-wrap">
                <input id="password" type="password" name="password"
                    class="field-input has-eye"
                    placeholder="Masukkan kata sandi"
                    autocomplete="current-password" required>
                <i class="fa-solid fa-lock field-icon"></i>
                <button type="button" class="eye-btn" id="togglePwd" aria-label="Tampilkan sandi">
                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit" id="loginBtn">
            <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
        </button>
    </form>

    <div class="divider">atau</div>
    <div class="bottom-link">Belum punya akun? <a href="/register">Daftar gratis</a></div>
    <div class="security"><i class="fa-solid fa-shield-halved"></i> Koneksi aman &amp; terenkripsi</div>
</div>

<script>
    const togglePwd = document.getElementById('togglePwd');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');
    togglePwd.addEventListener('click', () => {
        const show = pwdInput.type === 'password';
        pwdInput.type = show ? 'text' : 'password';
        eyeIcon.className = show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });
    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('loginBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btn.disabled = true;
    });
</script>
</body>
</html>