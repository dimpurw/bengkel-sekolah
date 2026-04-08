<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard – Manajemen Bengkel Sekolah</title>
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
            --sidebar-active: #2563eb;
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
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 14px 14px;
            border-bottom: 1px solid #ffffff14;
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
        }

        .nav-item:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .nav-item.active {
            background: #ffffff0f;
            color: #fff;
            font-weight: 700;
            border-left: 3px solid #f97316;
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

        /* Hamburger button */
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
            transition: background 0.15s, border-color 0.15s;
            padding: 0;
        }

        .btn-hamburger:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .btn-hamburger span {
            display: block;
            width: 16px;
            height: 2px;
            background: var(--text);
            border-radius: 2px;
            transition: transform 0.25s, opacity 0.2s, width 0.2s;
            transform-origin: center;
        }


        /* Sidebar transition */
        .sidebar {
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1),
                width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Collapsed state — slide out */
        .sidebar-collapsed .sidebar {
            transform: translateX(calc(-1 * var(--sidebar-w)));
            width: 0;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            background: #00000055;
            backdrop-filter: blur(1px);
            opacity: 0;
            transition: opacity 0.25s;
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

        /* ── STAT CARDS ── */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            border-radius: 14px;
            padding: 22px 20px;
            color: #fff;
            position: relative;
            overflow: hidden;
            min-height: 110px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            animation: fadeUp 0.5s both;
        }

        .stat-card:nth-child(1) {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #10b981, #059669);
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #f97316, #ea580c);
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #a855f7, #9333ea);
            animation-delay: 0.2s;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: #ffffff18;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            right: 20px;
            top: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #ffffff10;
        }

        .stat-num {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
            position: relative;
            z-index: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            opacity: 0.92;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── PANELS ── */
        .panels {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .panel {
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            overflow: hidden;
            animation: fadeUp 0.5s 0.25s both;
        }

        .panel-head {
            padding: 14px 18px 12px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text);
        }

        .panel-head svg {
            width: 16px;
            height: 16px;
        }

        .panel-head.warning {
            color: #b45309;
        }

        .panel-head.info {
            color: #1d4ed8;
        }

        .panel-body {
            padding: 12px 18px;
        }

        /* Stok menipis row */
        .stok-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .stok-row .item-name {
            font-weight: 600;
            color: #78350f;
        }

        .stok-badge {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
            border-radius: 6px;
            padding: 2px 10px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        /* Pengajuan terbaru */
        .empty-state {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 0.85rem;
            padding: 6px 0;
        }

        .empty-state svg {
            width: 16px;
            height: 16px;
            opacity: 0.6;
        }

        /* Responsive tweaks */
        @media (max-width: 900px) {
            .stat-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .panels {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            :root {
                --sidebar-w: 0px;
            }

            .sidebar {
                display: none;
            }

            .stat-cards {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Active page simulation */
        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* Generic table page */
        .page-title {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 18px;
            color: var(--text);
        }

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
    </style>
</head>

<body>
    <div class="app">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
                <div class="brand-text">
                    <div class="name">Manajemen Bengkel<br />Sekolah</div>
                    <div class="role">Administrator</div>
                </div>
            </div>

            <div class="nav-section">
                <a class="nav-item active" onclick="showPage('dashboard')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>
                <a class="nav-item" onclick="showPage('identitas')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" />
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    </svg>
                    Identitas Sekolah
                </a>
                <a class="nav-item" onclick="showPage('staf')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Master Staf Bengkel
                </a>
                <a class="nav-item" onclick="showPage('kelas')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    Master Kelas
                </a>
                <a class="nav-item" onclick="showPage('siswa')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Master Siswa
                </a>
                <a class="nav-item" onclick="showPage('lokasi')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="10" r="3" />
                        <path d="M12 2a8 8 0 0 0-8 8c0 5.4 7.05 11.5 7.35 11.76a1 1 0 0 0 1.3 0C12.95 21.5 20 15.4 20 10a8 8 0 0 0-8-8z" />
                    </svg>
                    Lokasi Penyimpanan
                </a>
                <a class="nav-item" onclick="showPage('barang-baik')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    </svg>
                    Barang (Kondisi Baik)
                </a>
                <a class="nav-item" onclick="showPage('barang-rusak')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                        <line x1="12" y1="12" x2="12" y2="16" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    Barang (Rusak/Arsip)
                </a>
                <a class="nav-item" onclick="showPage('bahan')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18M3 15h18M9 3v18" />
                    </svg>
                    Bahan Habis Pakai
                </a>
                <a class="nav-item" onclick="showPage('pengajuan-pinjam')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    Pengajuan Peminjaman
                </a>
                <a class="nav-item" onclick="showPage('pengajuan-bahan')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    Pengajuan Bahan
                </a>
                <a class="nav-item" onclick="showPage('rekap-dipinjam')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                    Rekap Barang Dipinjam
                </a>
                <a class="nav-item" onclick="showPage('rekap-bahan')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                    Rekap Bahan Keluar
                </a>
                <a class="nav-item" onclick="showPage('riwayat-pinjam')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    Riwayat Peminjaman
                </a>
                <a class="nav-item" onclick="showPage('riwayat-bahan')">
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
                <button class="btn-keluar" onclick="window.location.href='login-bengkel-sekolah.html'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Keluar
                </button>
            </div>
        </aside>

        <!-- ── MAIN ── -->
        <div class="main">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="btn-hamburger" id="btnHamburger" aria-label="Toggle sidebar">
                        <span></span><span></span><span></span>
                    </button>
                    <h1 id="pageTitle">Dashboard</h1>
                </div>
                <span class="topbar-date" id="topbarDate"></span>
            </div>

            <!-- Content -->
            <div class="content">

                <!-- DASHBOARD PAGE -->
                <div class="page active" id="page-dashboard">
                    <!-- Stat Cards -->
                    <div class="stat-cards">
                        <div class="stat-card">
                            <div class="stat-num">2</div>
                            <div class="stat-label">Barang (Baik)</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-num">2</div>
                            <div class="stat-label">Bahan Habis Pakai</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-num">5</div>
                            <div class="stat-label">Peminjaman Aktif</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-num">2</div>
                            <div class="stat-label">Siswa Terdaftar</div>
                        </div>
                    </div>

                    <!-- Panels -->
                    <div class="panels">
                        <!-- Stok Menipis -->
                        <div class="panel">
                            <div class="panel-head warning">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                                Stok Menipis
                            </div>
                            <div class="panel-body">
                                <div class="stok-row">
                                    <span class="item-name">Besi</span>
                                    <span class="stok-badge">Stok: 0</span>
                                </div>
                                <div class="stok-row">
                                    <span class="item-name">Oli Mesin</span>
                                    <span class="stok-badge">Stok: 1</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pengajuan Terbaru -->
                        <div class="panel">
                            <div class="panel-head info">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                Pengajuan Terbaru
                            </div>
                            <div class="panel-body">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    Tidak ada pengajuan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BARANG BAIK PAGE -->
                <div class="page" id="page-barang-baik">
                    <div class="data-table-wrap">
                        <div class="data-table-head">
                            <span>Daftar Barang (Kondisi Baik)</span>
                            <button class="btn-add">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Jumlah</th>
                                    <th>Lokasi</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kunci Ring 10</td>
                                    <td>KR-010</td>
                                    <td>5</td>
                                    <td>Rak A1</td>
                                    <td><span class="badge-baik">Baik</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Obeng Plus</td>
                                    <td>OP-001</td>
                                    <td>8</td>
                                    <td>Rak B2</td>
                                    <td><span class="badge-baik">Baik</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BARANG RUSAK PAGE -->
                <div class="page" id="page-barang-rusak">
                    <div class="data-table-wrap">
                        <div class="data-table-head">
                            <span>Daftar Barang (Rusak/Arsip)</span>
                            <button class="btn-add">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Tang Kombinasi</td>
                                    <td>TK-002</td>
                                    <td>2</td>
                                    <td>Pegangan retak</td>
                                    <td><span class="badge-rusak">Rusak</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SISWA PAGE -->
                <div class="page" id="page-siswa">
                    <div class="data-table-wrap">
                        <div class="data-table-head">
                            <span>Master Siswa</span>
                            <button class="btn-add">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>No. HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>2024001</td>
                                    <td>XII TKR 1</td>
                                    <td>081234567890</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Budi Santoso</td>
                                    <td>2024002</td>
                                    <td>XI TKR 2</td>
                                    <td>082345678901</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PENGAJUAN PINJAM PAGE -->
                <div class="page" id="page-pengajuan-pinjam">
                    <div class="data-table-wrap">
                        <div class="data-table-head">
                            <span>Pengajuan Peminjaman</span>
                            <button class="btn-add">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Tambah
                            </button>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>Kunci Ring 10</td>
                                    <td>1</td>
                                    <td>08/04/2026</td>
                                    <td><span class="badge-aktif">Aktif</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Budi Santoso</td>
                                    <td>Obeng Plus</td>
                                    <td>2</td>
                                    <td>07/04/2026</td>
                                    <td><span class="badge-aktif">Aktif</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- GENERIC PAGES -->
                <div class="page" id="page-identitas">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Identitas Sekolah</span></div>
                        <div style="padding:24px;color:var(--muted);font-size:0.87rem;">Halaman identitas sekolah.</div>
                    </div>
                </div>
                <div class="page" id="page-staf">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Master Staf Bengkel</span><button class="btn-add"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>Tambah</button></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>No. HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Drs. Hendra</td>
                                    <td>Kepala Bengkel</td>
                                    <td>08111222333</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-kelas">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Master Kelas</span><button class="btn-add"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>Tambah</button></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Jumlah Siswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>XII TKR 1</td>
                                    <td>Teknik Kendaraan Ringan</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>XI TKR 2</td>
                                    <td>Teknik Kendaraan Ringan</td>
                                    <td>28</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-lokasi">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Lokasi Penyimpanan</span><button class="btn-add"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>Tambah</button></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Lokasi</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Rak A1</td>
                                    <td>Rak kiri depan</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Rak B2</td>
                                    <td>Rak tengah baris 2</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-bahan">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Bahan Habis Pakai</span><button class="btn-add"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>Tambah</button></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Bahan</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Besi</td>
                                    <td>Batang</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Oli Mesin</td>
                                    <td>Liter</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-pengajuan-bahan">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Pengajuan Bahan</span></div>
                        <div style="padding:24px;color:var(--muted);font-size:0.87rem;">Belum ada pengajuan bahan.</div>
                    </div>
                </div>
                <div class="page" id="page-rekap-dipinjam">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Rekap Barang Dipinjam</span></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Peminjam</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kunci Ring 10</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>1</td>
                                    <td>08/04/2026</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-rekap-bahan">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Rekap Bahan Keluar</span></div>
                        <div style="padding:24px;color:var(--muted);font-size:0.87rem;">Belum ada data bahan keluar.</div>
                    </div>
                </div>
                <div class="page" id="page-riwayat-pinjam">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Riwayat Peminjaman</span></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align:center;color:var(--muted);padding:20px;">Belum ada riwayat.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="page" id="page-riwayat-bahan">
                    <div class="data-table-wrap">
                        <div class="data-table-head"><span>Riwayat Pengajuan Bahan</span></div>
                        <div style="padding:24px;color:var(--muted);font-size:0.87rem;">Belum ada riwayat pengajuan bahan.</div>
                    </div>
                </div>

            </div><!-- /content -->
        </div><!-- /main -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
    </div><!-- /app -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hamburger toggle
        const app = document.querySelector('.app');
        const btnHamburger = document.getElementById('btnHamburger');
        const overlay = document.getElementById('sidebarOverlay');

        // Sidebar open by default on all screen sizes
        app.classList.add('sidebar-open');

        btnHamburger.addEventListener('click', () => {
            if (app.classList.contains('sidebar-open')) {
                app.classList.remove('sidebar-open');
                app.classList.add('sidebar-collapsed');
            } else {
                app.classList.remove('sidebar-collapsed');
                app.classList.add('sidebar-open');
            }
        });

        overlay.addEventListener('click', () => {
            app.classList.remove('sidebar-open');
            app.classList.add('sidebar-collapsed');
        });
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        document.getElementById('topbarDate').textContent =
            `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        // Page navigation
        const pageTitles = {
            'dashboard': 'Dashboard',
            'identitas': 'Identitas Sekolah',
            'staf': 'Master Staf Bengkel',
            'kelas': 'Master Kelas',
            'siswa': 'Master Siswa',
            'lokasi': 'Lokasi Penyimpanan',
            'barang-baik': 'Barang (Kondisi Baik)',
            'barang-rusak': 'Barang (Rusak/Arsip)',
            'bahan': 'Bahan Habis Pakai',
            'pengajuan-pinjam': 'Pengajuan Peminjaman',
            'pengajuan-bahan': 'Pengajuan Bahan',
            'rekap-dipinjam': 'Rekap Barang Dipinjam',
            'rekap-bahan': 'Rekap Bahan Keluar',
            'riwayat-pinjam': 'Riwayat Peminjaman',
            'riwayat-bahan': 'Riwayat Pengajuan Bahan',
        };

        function showPage(id) {
            // Hide all pages
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            // Show target
            const target = document.getElementById('page-' + id);
            if (target) target.classList.add('active');
            // Update active nav
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            event.currentTarget.classList.add('active');
            // Update title
            document.getElementById('pageTitle').textContent = pageTitles[id] || id;
        }
    </script>
</body>

</html>