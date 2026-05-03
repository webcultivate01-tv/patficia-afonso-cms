<?php
date_default_timezone_set('Europe/Lisbon');

function db_badge(string $s): string {
    $map = [
        'paid'      => 'background:#dcfce7;color:#15803d',
        'pending'   => 'background:#fef9c3;color:#a16207',
        'overdue'   => 'background:#fee2e2;color:#dc2626',
        'active'    => 'background:#dbeafe;color:#1d4ed8',
        'completed' => 'background:#dcfce7;color:#15803d',
        'on-hold'   => 'background:#f1f5f9;color:#64748b',
        'cancelled' => 'background:#fee2e2;color:#dc2626',
    ];
    $style = $map[strtolower($s)] ?? 'background:#f1f5f9;color:#64748b';
    return "<span style='display:inline-block;padding:2px 10px;border-radius:20px;font-size:0.7rem;font-weight:600;{$style}'>".ucfirst($s)."</span>";
}
function eur(float $v): string { return number_format($v, 2, ',', '.') . ' €'; }
?>

<!-- ── STAT CARDS ── -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <?php
    $cards = [
        ['label' => 'Total Revenue',   'value' => eur($totalRevenue),    'icon_bg' => '#eff6ff', 'icon_color' => '#2563eb', 'sub' => 'All invoiced',         'sub_color' => '#64748b',
         'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Collected',       'value' => eur($totalCollected),  'icon_bg' => '#f0fdf4', 'icon_color' => '#16a34a', 'sub' => 'Paid invoices',        'sub_color' => '#16a34a',
         'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Outstanding',     'value' => eur($totalOutstanding),'icon_bg' => '#fff7ed', 'icon_color' => '#ea580c', 'sub' => 'Pending + overdue',    'sub_color' => '#ea580c',
         'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Overdue',         'value' => $overduePayments,      'icon_bg' => '#fef2f2', 'icon_color' => '#dc2626', 'sub' => 'Need attention',       'sub_color' => '#dc2626',
         'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
        ['label' => 'Total Clients',   'value' => $totalClients,         'icon_bg' => '#eff6ff', 'icon_color' => '#2563eb', 'sub' => 'Registered clients',   'sub_color' => '#64748b',
         'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => 'Total Projects',  'value' => $totalProjects,        'icon_bg' => '#eff6ff', 'icon_color' => '#2563eb', 'sub' => 'All projects',         'sub_color' => '#64748b',
         'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Active Projects', 'value' => $activeProjects,       'icon_bg' => '#eff6ff', 'icon_color' => '#2563eb', 'sub' => 'In progress',          'sub_color' => '#2563eb',
         'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
        ['label' => 'Pending Bills',   'value' => $pendingPayments,      'icon_bg' => '#fefce8', 'icon_color' => '#ca8a04', 'sub' => 'Awaiting payment',     'sub_color' => '#ca8a04',
         'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
    ];
    foreach ($cards as $card): ?>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?= $card['icon_bg'] ?>">
            <svg class="w-5 h-5" style="color:<?= $card['icon_color'] ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $card['icon'] ?>"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide leading-tight mb-0.5"><?= $card['label'] ?></p>
            <p class="text-xl font-extrabold text-slate-800 leading-tight"><?= $card['value'] ?></p>
            <p class="text-xs font-medium mt-0.5" style="color:<?= $card['sub_color'] ?>"><?= $card['sub'] ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- ── ROW 2: Revenue Line + Payment Doughnut ── -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-4">

    <!-- Revenue Line Chart -->
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-sm font-bold text-slate-800">Revenue Overview</h2>
                <p class="text-xs text-slate-400 mt-0.5">Collected payments — last 6 months</p>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                <?= eur($totalCollected) ?> total
            </span>
        </div>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <!-- Payment Status Doughnut -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col">
        <div class="mb-5">
            <h2 class="text-sm font-bold text-slate-800">Payment Status</h2>
            <p class="text-xs text-slate-400 mt-0.5">Breakdown of all invoices</p>
        </div>
        <div class="flex-1 flex items-center justify-center">
            <canvas id="statusChart" width="180" height="180"></canvas>
        </div>
        <div class="mt-4 space-y-2">
            <?php
            $statusLegend = [
                'paid'    => ['#16a34a', 'Paid',    $statusCounts['paid']],
                'pending' => ['#ca8a04', 'Pending', $statusCounts['pending']],
                'overdue' => ['#dc2626', 'Overdue', $statusCounts['overdue']],
            ];
            foreach ($statusLegend as [$color, $label, $count]): ?>
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:<?= $color ?>"></span>
                    <span class="text-slate-600 font-medium"><?= $label ?></span>
                </div>
                <span class="font-bold text-slate-800"><?= $count ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ── ROW 3: Project Status Bar + Top Clients Bar ── -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-4">

    <!-- Project Status Bar -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="mb-5">
            <h2 class="text-sm font-bold text-slate-800">Project Status</h2>
            <p class="text-xs text-slate-400 mt-0.5">Distribution across all projects</p>
        </div>
        <canvas id="projectChart" height="140"></canvas>
    </div>

    <!-- Top Clients by Revenue -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="mb-5">
            <h2 class="text-sm font-bold text-slate-800">Top Clients by Revenue</h2>
            <p class="text-xs text-slate-400 mt-0.5">Total billed per client</p>
        </div>
        <?php if (empty($topClients)): ?>
            <p class="text-sm text-slate-400 text-center py-10">No payment data yet</p>
        <?php else: ?>
        <canvas id="topClientsChart" height="140"></canvas>
        <?php endif; ?>
    </div>
</div>

<!-- ── ROW 4: Recent Tables ── -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    <!-- Recent Payments -->
    <div class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Recent Payments</h2>
            <a href="index.php?page=payments" class="text-xs text-blue-600 hover:underline font-semibold">View all</a>
        </div>
        <div class="divide-y divide-slate-50">
            <?php if (empty($recentPayments)): ?>
                <p class="text-sm text-slate-400 text-center py-8">No payments yet</p>
            <?php else: foreach ($recentPayments as $p): ?>
            <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0" style="background:#2563eb">
                    <?= strtoupper(substr($p['client_name'] ?? 'P', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate"><?= htmlspecialchars($p['client_name'] ?? '') ?></p>
                    <p class="text-xs text-slate-400 font-mono"><?= htmlspecialchars($p['invoice_id'] ?? '—') ?></p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs font-bold text-slate-800"><?= eur((float)($p['amount'] ?? 0)) ?></p>
                    <?= db_badge($p['status'] ?? 'pending') ?>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Recent Projects</h2>
            <a href="index.php?page=projects" class="text-xs text-blue-600 hover:underline font-semibold">View all</a>
        </div>
        <div class="divide-y divide-slate-50">
            <?php if (empty($recentProjects)): ?>
                <p class="text-sm text-slate-400 text-center py-8">No projects yet</p>
            <?php else: foreach ($recentProjects as $p): ?>
            <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                    <svg class="w-4 h-4" style="color:#2563eb" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate"><?= htmlspecialchars($p['title'] ?? '') ?></p>
                    <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($p['client_name'] ?? '') ?></p>
                </div>
                <div class="flex-shrink-0"><?= db_badge($p['status'] ?? 'active') ?></div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- Recent Clients -->
    <div class="xl:col-span-1 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Recent Clients</h2>
            <a href="index.php?page=clients" class="text-xs text-blue-600 hover:underline font-semibold">View all</a>
        </div>
        <div class="divide-y divide-slate-50">
            <?php if (empty($recentClients)): ?>
                <p class="text-sm text-slate-400 text-center py-8">No clients yet</p>
            <?php else: foreach ($recentClients as $c): ?>
            <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0" style="background:#2563eb">
                    <?= strtoupper(substr($c['name'] ?? 'C', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-800 truncate"><?= htmlspecialchars($c['name'] ?? '') ?></p>
                    <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($c['email'] ?? '') ?></p>
                </div>
                <?php if (!empty($c['company'])): ?>
                <span class="text-xs text-slate-400 truncate max-w-[70px] flex-shrink-0"><?= htmlspecialchars($c['company']) ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<!-- ── CHARTS JS ── -->
<script>
// ── 1. Revenue Line Chart ──
(function() {
    const labels = <?= json_encode(array_values($monthLabels)) ?>;
    const data   = <?= json_encode(array_values($monthlyRevenue)) ?>;
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 220);
    grad.addColorStop(0, 'rgba(37,99,235,0.18)');
    grad.addColorStop(1, 'rgba(37,99,235,0)');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Revenue (€)',
                data,
                borderColor: '#2563eb',
                backgroundColor: grad,
                borderWidth: 2.5,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y.toFixed(2).replace('.', ',') + ' €'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { size: 11 }, callback: v => v + ' €' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } }
                }
            }
        }
    });
})();

// ── 2. Payment Status Doughnut ──
(function() {
    const ctx = document.getElementById('statusChart').getContext('2d');
    const counts = <?= json_encode(array_values($statusCounts)) ?>;
    const total  = counts.reduce((a, b) => a + b, 0);
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Overdue'],
            datasets: [{
                data: counts,
                backgroundColor: ['#16a34a', '#ca8a04', '#dc2626'],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + (total ? ' (' + Math.round(ctx.parsed / total * 100) + '%)' : '')
                    }
                }
            }
        }
    });
})();

// ── 3. Project Status Bar ──
(function() {
    const ctx = document.getElementById('projectChart').getContext('2d');
    const data = <?= json_encode(array_values($projectStatusCounts)) ?>;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Completed', 'On Hold', 'Cancelled'],
            datasets: [{
                label: 'Projects',
                data,
                backgroundColor: ['#2563eb', '#16a34a', '#94a3b8', '#dc2626'],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { size: 11 }, stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 } }
                }
            }
        }
    });
})();

// ── 4. Top Clients Bar ──
<?php if (!empty($topClients)): ?>
(function() {
    const ctx = document.getElementById('topClientsChart').getContext('2d');
    const labels = <?= json_encode(array_keys($topClients)) ?>;
    const data   = <?= json_encode(array_values($topClients)) ?>;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Billed (€)',
                data,
                backgroundColor: 'rgba(37,99,235,0.8)',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.x.toFixed(2).replace('.', ',') + ' €'
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { size: 11 }, callback: v => v + ' €' }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { size: 11 } }
                }
            }
        }
    });
})();
<?php endif; ?>
</script>
