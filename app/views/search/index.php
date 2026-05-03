<!-- Search Bar -->
<div class="max-w-2xl mx-auto mb-8">
    <form method="GET" action="index.php" class="relative">
        <input type="hidden" name="page" value="search">
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" autofocus
                   placeholder="Search clients, projects, invoices..."
                   class="w-full pl-12 pr-4 py-3.5 text-sm border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition">
                Search
            </button>
        </div>
    </form>
</div>

<?php if ($q === ''): ?>
<div class="text-center py-20 text-slate-400">
    <svg class="w-14 h-14 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <p class="text-sm font-medium">Type something to search across all your data</p>
</div>

<?php elseif ($total === 0): ?>
<div class="text-center py-20 text-slate-400">
    <svg class="w-14 h-14 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="text-sm font-medium">No results for "<strong class="text-slate-600"><?= htmlspecialchars($q) ?></strong>"</p>
</div>

<?php else: ?>
<p class="text-xs text-slate-400 mb-5 text-center"><?= $total ?> result<?= $total > 1 ? 's' : '' ?> for "<strong class="text-slate-600"><?= htmlspecialchars($q) ?></strong>"</p>

<div class="space-y-5">

<?php if (!empty($clients)): ?>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <h3 class="text-sm font-bold text-slate-800">Clients <span class="text-slate-400 font-normal">(<?= count($clients) ?>)</span></h3>
    </div>
    <div class="divide-y divide-slate-50">
        <?php foreach ($clients as $c): ?>
        <a href="index.php?page=clients&action=view&id=<?= $c['_id'] ?>" class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0" style="background:#2563eb">
                <?= strtoupper(substr($c['name'] ?? 'C', 0, 1)) ?>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($c['name'] ?? '') ?></p>
                <p class="text-xs text-slate-400"><?= htmlspecialchars($c['email'] ?? '') ?><?= !empty($c['company']) ? ' · ' . htmlspecialchars($c['company']) : '' ?></p>
            </div>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($projects)): ?>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h3 class="text-sm font-bold text-slate-800">Projects <span class="text-slate-400 font-normal">(<?= count($projects) ?>)</span></h3>
    </div>
    <div class="divide-y divide-slate-50">
        <?php foreach ($projects as $p):
            $sc = ['active'=>'bg-blue-100 text-blue-700','completed'=>'bg-green-100 text-green-700','on-hold'=>'bg-slate-100 text-slate-600','cancelled'=>'bg-red-100 text-red-600'];
            $cls = $sc[strtolower($p['status'] ?? '')] ?? 'bg-slate-100 text-slate-600';
        ?>
        <a href="index.php?page=projects&action=edit&id=<?= $p['_id'] ?>" class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#eff6ff">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($p['title'] ?? '') ?></p>
                <p class="text-xs text-slate-400"><?= htmlspecialchars($p['client_name'] ?? '') ?><?= !empty($p['deadline']) ? ' · Due ' . $p['deadline'] : '' ?></p>
            </div>
            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $cls ?>"><?= ucfirst($p['status'] ?? '') ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($payments)): ?>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        <h3 class="text-sm font-bold text-slate-800">Payments <span class="text-slate-400 font-normal">(<?= count($payments) ?>)</span></h3>
    </div>
    <div class="divide-y divide-slate-50">
        <?php foreach ($payments as $p):
            $sc = ['paid'=>'bg-green-100 text-green-700','pending'=>'bg-yellow-100 text-yellow-700','overdue'=>'bg-red-100 text-red-700'];
            $cls = $sc[strtolower($p['status'] ?? '')] ?? 'bg-slate-100 text-slate-600';
        ?>
        <a href="index.php?page=payments&action=invoice&id=<?= $p['_id'] ?>" target="_blank" class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50 transition">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 bg-emerald-50">
                <span class="text-emerald-600 font-bold text-xs">€</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($p['client_name'] ?? '') ?> <span class="text-slate-400 font-normal font-mono text-xs">#<?= htmlspecialchars($p['invoice_id'] ?? '') ?></span></p>
                <p class="text-xs text-slate-400"><?= htmlspecialchars($p['description'] ?? '') ?></p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-sm font-bold text-slate-800"><?= number_format($p['amount'] ?? 0, 2, ',', '.') ?> €</p>
                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold <?= $cls ?>"><?= ucfirst($p['status'] ?? '') ?></span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

</div>
<?php endif; ?>
