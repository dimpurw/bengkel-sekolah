<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manajemen Bengkel Sekolah')</title>
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
            --sidebar-bg: #1a2340;
            --sidebar-w: 210px;
            --sidebar-hover: #ffffff12;
            --topbar-h: 56px;
            --blue: #2563eb;
            --green: #10b981;
            --orange: #f97316;
            --purple: #a855f7;
            --body-bg: #f1f4f9;
            --white: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --font: 'Plus Jakarta Sans', sans-serif;
        }

        html,
        body {
            height: 100%;
            font-family: var(--font);
            background: var(--body-bg);
            color: var(--text);
            overflow: hidden;
        }

        /* ── LAYOUT ── */
        .app {
            display: flex;
            height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-collapsed .sidebar {
            transform: translateX(calc(-1 * var(--sidebar-w)));
            width: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 14px 14px;
            border-bottom: 1px solid #ffffff14;
            flex-shrink: 0;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            flex-shrink: 0;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon svg {
            width: 18px;
            height: 18px;
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-text .name {
            font-size: 0.78rem;
            font-weight: 700;
            color: #fff;
        }

        .brand-text .role {
            font-size: 0.68rem;
            color: var(--blue);
            font-weight: 600;
        }

        .nav-section {
            padding: 10px 8px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            color: #b0bcd4;
            transition: background 0.15s, color 0.15s;
            user-select: none;
            text-decoration: none;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .nav-item.active {
            background: #ffffff0f;
            color: #fff;
            font-weight: 700;
            border-left: 3px solid var(--orange);
            padding-left: 7px;
        }

        .nav-item svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            opacity: 0.8;
        }

        .nav-item.active svg {
            opacity: 1;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid #ffffff14;
            padding: 12px 8px 10px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2563eb44;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-avatar svg {
            width: 16px;
            height: 16px;
            color: #93c5fd;
        }

        .user-name {
            font-size: 0.78rem;
            font-weight: 700;
            color: #fff;
        }

        .user-role {
            font-size: 0.68rem;
            color: #60a5fa;
            font-weight: 500;
        }

        .btn-keluar {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 9px 10px;
            background: #ffffff0d;
            border: none;
            border-radius: 8px;
            color: #b0bcd4;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }

        .btn-keluar:hover {
            background: #ef444422;
            color: #fca5a5;
        }

        .btn-keluar svg {
            width: 15px;
            height: 15px;
        }

        /* ── MAIN ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 0 16px;
            flex-shrink: 0;
            gap: 12px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar h1 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text);
        }

        .topbar-date {
            font-size: 0.82rem;
            color: var(--muted);
            font-weight: 500;
            white-space: nowrap;
        }

        .btn-hamburger {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: none;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s;
            padding: 0;
        }

        .btn-hamburger:hover {
            background: #f1f5f9;
        }

        .btn-hamburger span {
            display: block;
            width: 16px;
            height: 2px;
            background: var(--text);
            border-radius: 2px;
        }

        /* ── CONTENT ── */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 24px 28px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .content::-webkit-scrollbar {
            width: 5px;
        }

        .content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        /* ── IDENTITAS FORM ── */
        .identitas-wrap {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .identitas-form-panel {
            flex: 1;
            min-width: 0;
        }

        .identitas-preview-panel {
            width: 300px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .identitas-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
        }

        .identitas-card-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .identitas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 20px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: 0.1px;
        }

        .field-input {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.85rem;
            font-family: var(--font);
            color: var(--text);
            background: #fafbff;
            outline: none;
            width: 100%;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field-input:focus {
            border-color: var(--blue);
            background: #fff;
            box-shadow: 0 0 0 3px #2563eb18;
        }

        .field-input.is-invalid {
            border-color: #ef4444;
        }

        .btn-simpan {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 0.88rem;
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            transition: filter 0.15s, transform 0.1s;
        }

        .btn-simpan:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        .btn-simpan:active {
            transform: translateY(0);
        }

        .preview-block {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .preview-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text);
            padding: 11px 14px;
            border-bottom: 1px solid var(--border);
            background: #fafbff;
        }

        .preview-img-wrap {
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            min-height: 100px;
        }

        .preview-img-wrap img {
            max-width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .preview-photo {
            padding: 0;
        }

        .preview-photo img {
            border-radius: 0;
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        /* ── DATA TABLE ── */
        .data-table-wrap {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .data-table-head {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .data-table-head span {
            font-size: 0.88rem;
            font-weight: 700;
        }

        .btn-add {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: filter 0.15s;
        }

        .btn-add:hover {
            filter: brightness(1.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--muted);
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        td {
            padding: 11px 16px;
            font-size: 0.83rem;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .badge-baik {
            background: #d1fae5;
            color: #065f46;
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.73rem;
            font-weight: 700;
        }

        .badge-rusak {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.73rem;
            font-weight: 700;
        }

        .badge-aktif {
            background: #dbeafe;
            color: #1e40af;
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.73rem;
            font-weight: 700;
        }

        /* ── ALERT ── */
        .alert-success-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 10px;
            padding: 12px 20px;
            font-size: 0.87rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 20px #00000018;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 900px) {
            .identitas-wrap {
                flex-direction: column;
            }

            .identitas-preview-panel {
                width: 100%;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .preview-block {
                flex: 1;
                min-width: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar-overlay {
                display: block;
                pointer-events: none;
            }

            .sidebar-open .sidebar-overlay {
                opacity: 1;
                pointer-events: auto;
            }

            .sidebar-open .sidebar {
                transform: translateX(0) !important;
                width: var(--sidebar-w) !important;
                position: fixed;
                z-index: 100;
                top: 0;
                left: 0;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            background: #00000055;
            opacity: 0;
            transition: opacity 0.25s;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="app sidebar-open" id="appWrap">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
                <div class="brand-text">
                    <div class="name">Manajemen Bengkel<br>Sekolah</div>
                    <div class="role">Administrator</div>
                </div>
            </div>

            <div class="nav-section">
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    </svg>
                    Identitas Sekolah
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Master Staf Bengkel
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    Master Kelas
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Master Siswa
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="10" r="3" />
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z" />
                    </svg>
                    Lokasi Penyimpanan
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    </svg>
                    Barang (Kondisi Baik)
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <line x1="12" y1="12" x2="12" y2="16" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    Barang (Rusak/Arsip)
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18M3 15h18M9 3v18" />
                    </svg>
                    Bahan Habis Pakai
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    Pengajuan Peminjaman
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Pengajuan Bahan
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                    Rekap Barang Dipinjam
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                    Rekap Bahan Keluar
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    Riwayat Peminjaman
                </a>
                <a href="" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    Riwayat Pengajuan Bahan
                </a>
            </div>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <div class="user-name">Administrator</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="">
                    @csrf
                    <button type="submit" class="btn-keluar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="main">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="btn-hamburger" id="btnHamburger" aria-label="Toggle sidebar">
                        <span></span><span></span><span></span>
                    </button>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
                <span class="topbar-date" id="topbarDate"></span>
            </div>

            <!-- Content -->
            <div class="content">
                {{-- Flash success --}}
                @if(session('success'))
                <div class="alert-success-toast" id="flashToast">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </div>
        </div>

        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div><!-- /app -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Date
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('topbarDate').textContent =
            `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        // Hamburger
        const appWrap = document.getElementById('appWrap');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('btnHamburger').addEventListener('click', () => {
            appWrap.classList.toggle('sidebar-open');
            appWrap.classList.toggle('sidebar-collapsed');
        });
        overlay.addEventListener('click', () => {
            appWrap.classList.remove('sidebar-open');
            appWrap.classList.add('sidebar-collapsed');
        });

        // Auto-hide flash toast
        const toast = document.getElementById('flashToast');
        if (toast) setTimeout(() => toast.remove(), 3500);
    </script>
    @stack('scripts')
</body>

</html>