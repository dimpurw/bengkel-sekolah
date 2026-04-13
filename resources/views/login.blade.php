<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Bengkel Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue-deep: #0a1628;
            --blue-mid: #0d2a6b;
            --blue-vivid: #1a4fd6;
            --blue-bright: #2563eb;
            --blue-light: #3b82f6;
            --blue-glow: #60a5fa;
            --white: #ffffff;
            --gray-soft: #f0f4ff;
            --gray-border: #d1daf5;
            --text-dark: #0f172a;
            --text-mid: #475569;
            --text-hint: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(ellipse 80% 70% at 65% 40%, #2f6bec 0%, #1a4dd4 25%, #0d2f9e 55%, #07185a 80%, #04102e 100%);
            position: relative;
            overflow: hidden;
        }

        /* Subtle noise/grain overlay for depth */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.18;
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            display: none;
        }

        /* Grid dot overlay */
        .bg-grid {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #ffffff08 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }

        /* Card */
        .card-login {
            background: var(--white);
            border-radius: 20px;
            padding: 44px 40px 36px;
            width: 100%;
            max-width: 440px;
            box-shadow:
                0 0 0 1px #e2e8f0,
                0 20px 60px -10px #04102e88,
                0 4px 16px #0000002a;
            animation: cardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
            position: relative;
            z-index: 10;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(28px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Logo */
        .logo-wrap {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--blue-bright) 0%, var(--blue-vivid) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px #2563eb55;
            animation: logoPop 0.5s 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        @keyframes logoPop {
            from {
                opacity: 0;
                transform: scale(0.6);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .logo-wrap svg {
            width: 32px;
            height: 32px;
        }

        /* Headings */
        .card-login h1 {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-dark);
            text-align: center;
            letter-spacing: -0.4px;
            margin-bottom: 4px;
        }

        .card-login .subtitle {
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-mid);
            margin-bottom: 28px;
            font-weight: 500;
        }

        /* Form label */
        .form-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }

        /* Input */
        .form-control {
            border: 1.5px solid var(--gray-border);
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background: #fafbff;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-control::placeholder {
            color: var(--text-hint);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--blue-bright);
            background: #fff;
            box-shadow: 0 0 0 3.5px #2563eb22;
        }

        /* Input wrapper for icon */
        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .form-control {
            padding-left: 40px;
        }

        .input-icon-wrap .icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-hint);
            pointer-events: none;
        }

        /* Password toggle */
        .toggle-pass {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            color: var(--text-hint);
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .toggle-pass:hover {
            color: var(--blue-bright);
        }

        /* Button */
        .btn-masuk {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: 0.3px;
            border: none;
            background: linear-gradient(135deg, var(--blue-bright) 0%, var(--blue-vivid) 100%);
            color: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s, box-shadow 0.2s, filter 0.2s;
            box-shadow: 0 4px 16px #2563eb44;
        }

        .btn-masuk::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #ffffff22, transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-masuk:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px #2563eb55;
            filter: brightness(1.05);
        }

        .btn-masuk:hover::after {
            opacity: 1;
        }

        .btn-masuk:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px #2563eb33;
        }

        /* Spinner inside button */
        .btn-masuk .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2.5px solid #ffffff66;
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-masuk.loading .spinner {
            display: inline-block;
        }

        .btn-masuk.loading .btn-text {
            opacity: 0.7;
        }

        /* Default credentials box */
        .cred-box {
            background: #f0f5ff;
            border: 1px solid #c7d9ff;
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .cred-box .cred-icon {
            width: 28px;
            height: 28px;
            background: var(--blue-bright);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .cred-box .cred-icon svg {
            width: 14px;
            height: 14px;
        }

        .cred-box .cred-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cred-box .cred-info {
            font-size: 0.83rem;
            color: #374151;
            font-weight: 500;
        }

        .cred-box .cred-info strong {
            color: var(--blue-bright);
            font-weight: 700;
        }

        /* Toast */
        .toast-error {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 20px #00000022;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s, top 0.25s;
            z-index: 999;
        }

        .toast-error.show {
            opacity: 1;
            top: 32px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card-login {
                padding: 36px 24px 28px;
                margin: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-grid"></div>

    <!-- Toast -->
    <div class="toast-error" id="toastError">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <span id="toastMsg">Username atau password salah!</span>
    </div>

    <div class="card-login">
        <!-- Logo -->
        <div class="logo-wrap">
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 20L10 12L14 17L18 10L22 20H6Z" fill="white" opacity="0.9" />
                <circle cx="22" cy="10" r="3" fill="white" opacity="0.7" />
                <rect x="5" y="22" width="22" height="3" rx="1.5" fill="white" opacity="0.5" />
            </svg>
        </div>

        <h1>Manajemen Bengkel Sekolah</h1>
        <p class="subtitle">Silakan login untuk melanjutkan</p>

        <!-- Form -->
        <form action="{{ route('login.store') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-icon-wrap">
                    <span class="icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <input type="text" name="username" class="form-control" id="username" required placeholder="Masukkan username" autocomplete="username" />
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <span class="icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </span>
                    <input type="password" name="password" class="form-control" id="password" required placeholder="Masukkan password" autocomplete="current-password" />
                    <button class="toggle-pass" id="togglePass" type="button" aria-label="Tampilkan password">
                        <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <button class="btn-masuk" id="btnMasuk" type="submit">
                <span class="spinner"></span>
                <span class="btn-text">Masuk</span>
            </button>
        </form>

        <!-- Default credentials -->
        <div class="cred-box">
            <div class="cred-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div>
                <div class="cred-label">Default Admin</div>
                <div class="cred-info">
                    Username: <strong>admin</strong> &nbsp;|&nbsp; Password: <strong>admin123</strong>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePass = document.getElementById('togglePass');
        const eyeIcon = document.getElementById('eyeIcon');
        const toastEl = document.getElementById('toastError');
        const toastMsg = document.getElementById('toastMsg');

        // Password toggle
        const eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
        const eyeClose = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

        let passVisible = false;
        togglePass.addEventListener('click', () => {
            passVisible = !passVisible;
            passwordEl.type = passVisible ? 'text' : 'password';
            eyeIcon.innerHTML = passVisible ? eyeClose : eyeOpen;
        });
    </script>
    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toastEl = document.getElementById('toastError');
            const toastMsg = document.getElementById('toastMsg');

            function showToast(msg) {
                toastMsg.textContent = msg;
                toastEl.classList.add('show');
                setTimeout(() => toastEl.classList.remove('show'), 3000);
            }

            showToast(@json($errors->first()));

        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toastEl = document.getElementById('toastError');
            const toastMsg = document.getElementById('toastMsg');

            function showToast(msg) {
                toastMsg.textContent = msg;
                toastEl.classList.add('show');
                setTimeout(() => toastEl.classList.remove('show'), 3000);
            }

            showToast(@json(session('error')));

        });
    </script>
    @endif
</body>

</html>