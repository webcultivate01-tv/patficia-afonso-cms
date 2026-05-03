<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAGraphics — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * { font-family: 'Inter', -apple-system, sans-serif; }

        /* ── Sidebar ── */
        .sidebar { background: #1e3a5f; }
        .sidebar-logo-wrap { border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-section-label { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.35); padding: 0 12px; margin-bottom: 4px; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 7px;
            font-size: 0.875rem; font-weight: 500;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            transition: all 0.15s;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: #2563eb; color: #fff; font-weight: 600; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }

        .sidebar-footer { border-top: 1px solid rgba(255,255,255,0.08); }
        .user-block { background: rgba(255,255,255,0.06); border-radius: 8px; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        /* ── Stat cards ── */
        .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; }
        .stat-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

        /* ── Buttons ── */
        .btn-primary { background:#2563eb; color:#fff; padding:9px 18px; border-radius:8px; font-size:.875rem; font-weight:600; display:inline-flex; align-items:center; gap:6px; text-decoration:none; border:none; cursor:pointer; transition:background .15s; }
        .btn-primary:hover { background:#1d4ed8; }
        .btn-secondary { background:#f1f5f9; color:#475569; padding:9px 18px; border-radius:8px; font-size:.875rem; font-weight:600; display:inline-flex; align-items:center; gap:6px; text-decoration:none; border:none; cursor:pointer; transition:background .15s; }
        .btn-secondary:hover { background:#e2e8f0; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

<?php
date_default_timezone_set('Europe/Lisbon');
$currentPage = $_GET['page'] ?? 'dashboard';
?>

<div class="flex h-screen overflow-hidden">

    <!-- ── SIDEBAR ── -->
    <aside class="sidebar w-56 flex-shrink-0 flex flex-col">

        <!-- Logo -->
        <div class="sidebar-logo-wrap flex items-center gap-3 px-4 py-4">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#2563eb">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <a href="index.html" class="block min-w-0">
                <p class="text-white font-bold text-sm leading-tight">PAGraphics</p>
                <p class="text-xs" style="color:rgba(255,255,255,0.4)">Admin Panel</p>
            </a>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            <p class="sidebar-section-label mb-2">Main</p>

            <?php
            $links = [
                'dashboard' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard', 'group' => 'main'],
                'clients'   => ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Clients', 'group' => 'main'],
                'projects'  => ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label' => 'Projects', 'group' => 'main'],
                'payments'  => ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'label' => 'Payments', 'group' => 'main'],
                'services'  => ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'label' => 'Services', 'group' => 'main'],
                'bills'     => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Bills',     'group' => 'main'],
                'quotes'    => ['icon' => 'M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2', 'label' => 'Quotes',    'group' => 'main'],
                'calendar'  => ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Calendar',  'group' => 'main'],
                'reports'   => ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'label' => 'Reports',   'group' => 'main'],
                'aging'     => ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Aging',     'group' => 'main'],
                'statement' => ['icon' => 'M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Statement', 'group' => 'main'],
                'search'    => ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'label' => 'Search',    'group' => 'tools'],
                'admins'    => ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Admins',    'group' => 'settings'],
                'profile'   => ['icon' => 'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'My Profile', 'group' => 'settings'], ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Admins', 'group' => 'settings'],
            ];
            $printedSettings = false;
            $printedTools    = false;
            foreach ($links as $pg => $info):
                if ($info['group'] === 'tools' && !$printedTools):
                    $printedTools = true;
            ?>
            <div class="pt-4 pb-1"><p class="sidebar-section-label">Tools</p></div>
            <?php endif; ?>
            <?php if ($info['group'] === 'settings' && !$printedSettings):
                    $printedSettings = true;
            ?>
            <div class="pt-4 pb-1"><p class="sidebar-section-label">Settings</p></div>
            <?php endif; ?>
            <a href="index.php?page=<?= $pg ?>" class="nav-item <?= $currentPage === $pg ? 'active' : '' ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $info['icon'] ?>"/>
                </svg>
                <?= $info['label'] ?>
            </a>
            <?php endforeach; ?>
        </nav>

        <!-- User Footer -->
        <div class="sidebar-footer px-3 py-3">
            <div class="user-block flex items-center gap-2.5 px-3 py-2.5">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#2563eb">
                    <?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-semibold truncate leading-tight"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></p>
                    <p class="text-xs truncate leading-tight" style="color:rgba(255,255,255,0.4)"><?= ucfirst($_SESSION['admin_role'] ?? 'admin') ?></p>
                </div>
                <a href="index.php?page=logout" title="Logout" onclick="return confirm('Log out?')"
                   class="flex-shrink-0 p-1 rounded transition hover:bg-red-500/20"
                   style="color:rgba(255,255,255,0.4)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                    </svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- ── MAIN ── -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Topbar -->
        <header class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-sm font-bold text-slate-800"><?= ucfirst($currentPage) ?></h1>
                <p class="text-xs text-slate-400"><?= date('l, j F Y · H:i') ?> (Lisbon)</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- Global Search -->
                <form method="GET" action="index.php" class="relative">
                    <input type="hidden" name="page" value="search">
                    <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                           class="w-48 pl-8 pr-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:w-64 transition-all bg-slate-50">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
                <a href="index.html" class="btn-secondary text-xs py-1.5 px-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Site
                </a>
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-emerald-200">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    Live
                </span>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <?php require $viewFile; ?>
        </main>
    </div>
</div>

</body>
</html>
