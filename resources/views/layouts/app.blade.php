<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penjualan Sederhana') - NusaKasir</title>
    <style>
        :root {
            --bg: #f4f6f5;
            --card: #ffffff;
            --text: #1c2b25;
            --muted: #6b7a74;
            --line: #e6ebe8;
            --brand: #1f6b4a;
            --brand-dark: #17543a;
            --brand-soft: #e7f3ed;
            --sidebar: #17221e;
            --danger: #dc2626;
            --radius: 14px;
            --shadow: 0 1px 2px rgba(16, 24, 20, .04), 0 4px 14px rgba(16, 24, 20, .05);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Segoe UI", system-ui, -apple-system, Arial, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            color: var(--text);
            background: var(--bg);
        }

        /* ===== Kerangka halaman ===== */
        .app { display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px;
            background: var(--sidebar);
            color: #cfe0d8;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            position: sticky;
            top: 0;
            height: 100vh;
            flex-shrink: 0;
        }
        .brand { display: flex; align-items: center; gap: 10px; padding: 0 8px; }
        .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--brand); color: #fff;
            display: grid; place-items: center; font-weight: 800;
        }
        .brand-name { color: #fff; font-weight: 700; font-size: 17px; }
        .menu-label {
            font-size: 11px; letter-spacing: .08em; text-transform: uppercase;
            color: #7f958b; padding: 0 12px; margin-bottom: 8px;
        }
        .menu a {
            display: block; padding: 10px 12px; border-radius: 10px;
            color: #cfe0d8; text-decoration: none; font-weight: 600;
            transition: background .15s;
        }
        .menu a:hover { background: rgba(255, 255, 255, .06); }
        .menu a.active { background: #2a3d35; color: #fff; }
        .sidebar-foot {
            margin-top: auto; padding: 14px 12px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            font-size: 13px; color: #8aa095;
        }
        .sidebar-foot strong { display: block; color: #fff; font-size: 14px; }

        .main { flex: 1; min-width: 0; }
        .header {
            background: #fff; border-bottom: 1px solid var(--line);
            padding: 14px 32px; display: flex;
            justify-content: space-between; align-items: center;
            font-size: 14px; color: var(--muted);
        }
        .header b { color: var(--text); }
        .user { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--brand-soft); color: var(--brand);
            display: grid; place-items: center; font-weight: 700; font-size: 13px;
        }
        .container { max-width: 1100px; margin: 0 auto; padding: 32px; }

        /* ===== Teks ===== */
        h1, h2, p { margin-top: 0; }
        h1 { font-size: 28px; line-height: 1.2; margin-bottom: 4px; letter-spacing: -.02em; }
        .muted { color: var(--muted); }
        .topbar {
            display: flex; justify-content: space-between; align-items: flex-end;
            gap: 16px; margin-bottom: 24px;
        }

        /* ===== Kartu ===== */
        .card {
            background: var(--card); border: 1px solid var(--line);
            border-radius: var(--radius); padding: 22px; margin-bottom: 20px;
            box-shadow: var(--shadow);
        }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .summary-grid { grid-template-columns: repeat(4, 1fr); }
        .summary-grid .card { transition: transform .15s, box-shadow .15s; }
        .summary-grid .card:hover { transform: translateY(-2px); }
        .summary-grid .card:nth-child(1) { border-top: 3px solid var(--brand); }
        .summary-grid .card:nth-child(2) { border-top: 3px solid #22a35a; }
        .summary-grid .card:nth-child(3) { border-top: 3px solid #f0a420; }
        .summary-grid .card:nth-child(4) { border-top: 3px solid #e5484d; }
        .metric { font-size: 30px; font-weight: 800; letter-spacing: -.02em; }
        .full { grid-column: 1 / -1; }

        /* ===== Form ===== */
        label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        input, select, textarea {
            width: 100%; padding: 11px 13px; border: 1px solid #d5ddd9;
            border-radius: 10px; background: #fff; font: inherit; color: var(--text);
            transition: border-color .15s, box-shadow .15s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(31, 107, 74, .15);
        }
        textarea { min-height: 96px; resize: vertical; }
        .error { color: var(--danger); font-size: 13px; margin-top: 5px; font-weight: 500; }

        /* ===== Tombol ===== */
        .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .actions form { margin: 0; }
        .btn {
            display: inline-block; border: 1px solid var(--line); border-radius: 10px;
            padding: 9px 15px; text-decoration: none; cursor: pointer;
            font: inherit; font-weight: 600; font-size: 14px;
            background: #fff; color: var(--text);
            transition: background .15s, transform .1s, box-shadow .15s;
        }
        .btn:hover { background: #f1f5f3; }
        .btn:active { transform: translateY(1px); }
        .btn-primary { background: var(--brand); border-color: var(--brand); color: #fff; }
        .btn-primary:hover { background: var(--brand-dark); }
        .btn-danger { background: #fff1f1; border-color: #fbd5d5; color: #b42318; }
        .btn-danger:hover { background: #fee2e2; }

        /* ===== Tabel ===== */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid var(--line); }
        th {
            font-size: 12px; text-transform: uppercase; letter-spacing: .05em;
            color: var(--muted); background: #fafcfb; font-weight: 700;
        }
        tbody tr { transition: background .12s; }
        tbody tr:hover { background: #f7faf8; }
        tbody tr:last-child td { border-bottom: 0; }
        td .btn { padding: 6px 11px; font-size: 13px; }

        /* ===== Badge ===== */
        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 11px; border-radius: 999px;
            background: #eef1ef; color: #4b5a54; font-size: 12px; font-weight: 700;
        }
        .badge::before {
            content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor;
        }
        .badge-selesai { background: #e3f6ea; color: #17803d; }
        .badge-pending { background: #fff3d6; color: #a15c07; }
        .badge-batal   { background: #fde8e8; color: #b42318; }

        /* ===== Alert ===== */
        .alert { padding: 13px 16px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; }
        .alert-success { background: #e3f6ea; color: #17803d; border: 1px solid #bfe8cf; }
        .alert-error { background: #fde8e8; color: #b42318; border: 1px solid #f8c9c9; }

        /* ===== Pagination ===== */
        .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; }
        .pagination .page-link {
            display: block; padding: 7px 13px; border: 1px solid var(--line);
            border-radius: 9px; color: var(--text); text-decoration: none;
            background: #fff; font-weight: 600; font-size: 14px;
        }
        .pagination a.page-link:hover { background: var(--brand-soft); }
        .pagination .active .page-link { background: var(--brand); color: #fff; border-color: var(--brand); }
        .pagination .disabled .page-link { color: #a7b3ad; background: #f7f9f8; }
        nav .small, nav p.small { font-size: 13px; color: var(--muted); margin: 0 0 10px; }

        /* utilitas kecil agar pagination bawaan tidak dobel */
        .d-none { display: none !important; }
        .d-flex { display: flex; }
        .flex-fill { flex: 1 1 auto; }
        .justify-content-between { justify-content: space-between; }
        .align-items-center { align-items: center; }
        @media (min-width: 576px) {
            .d-sm-none { display: none !important; }
            .d-sm-flex { display: flex !important; }
            .flex-sm-fill { flex: 1 1 auto; }
            .align-items-sm-center { align-items: center; }
            .justify-content-sm-between { justify-content: space-between; }
        }

        /* ===== Responsif ===== */
        @media (max-width: 900px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 800px) {
            .app { flex-direction: column; }
            .sidebar {
                width: 100%; height: auto; position: static;
                flex-direction: row; align-items: center;
                padding: 12px 16px; gap: 16px;
            }
            .menu-label, .sidebar-foot { display: none; }
            .header { padding: 12px 16px; }
            .container { padding: 20px 16px; }
        }
        @media (max-width: 700px) {
            .grid { grid-template-columns: 1fr; }
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            .topbar { align-items: flex-start; flex-direction: column; }
            h1 { font-size: 24px; }
            .card { padding: 16px; }
            table { display: block; overflow-x: auto; white-space: nowrap; }
        }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon">N</div>
                <span class="brand-name">NusaKasir</span>
            </div>

            <nav class="menu">
                <div class="menu-label">Menu Utama</div>
                <a href="{{ route('penjualan.index') }}" class="active">Transaksi Penjualan</a>
            </nav>

            <div class="sidebar-foot">
                <strong>Praktikum Laravel</strong>
                CRUD penjualan sederhana
            </div>
        </aside>

        <div class="main">
            <header class="header">
                <div>Aplikasi / <b>@yield('title', 'Penjualan')</b></div>
                <div class="user">
                    <span>Admin Toko</span>
                    <div class="avatar">AT</div>
                </div>
            </header>

            <main class="container">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>