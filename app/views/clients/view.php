<?php
function cp_badge(string $s): string {
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
function cp_eur(float $v): string { return number_format($v, 2, ',', '.') . ' €'; }
$initial = strtoupper(substr($client['name'] ?? 'C', 0, 1));
$phone   = preg_replace('/\D/', '', $client['phone'] ?? '');
?>

<!-- Back -->
<div class="mb-5">
    <a href="index.php?page=clients" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Clients
    </a>
</div>

<!-- Profile Header -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5">
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl font-black flex-shrink-0" style="background:#2563eb">
                <?= $initial ?>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900"><?= htmlspecialchars($client['name'] ?? '') ?></h1>
                <?php if (!empty($client['company'])): ?>
                <p class="text-sm font-semibold text-slate-500 mt-0.5"><?= htmlspecialchars($client['company']) ?></p>
                <?php endif; ?>
                <div class="flex flex-wrap gap-4 mt-2">
                    <?php if (!empty($client['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($client['email']) ?>" class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <?= htmlspecialchars($client['email']) ?>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($client['phone'])): ?>
                    <a href="tel:<?= htmlspecialchars($client['phone']) ?>" class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <?= htmlspecialchars($client['phone']) ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-2">
            <?php if ($phone): ?>
            <a href="https://wa.me/<?= $phone ?>?text=<?= urlencode('Hi ' . ($client['name'] ?? '') . ', I wanted to follow up regarding our project. Please let me know if you have any questions. — PAGraphics') ?>"
               target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                WhatsApp
            </a>
            <?php endif; ?>
            <?php if (!empty($client['email'])): ?>
            <a href="mailto:<?= htmlspecialchars($client['email']) ?>"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Send Email
            </a>
            <?php endif; ?>
            <a href="index.php?page=clients&action=edit&id=<?= $client['_id'] ?>"
               class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold px-4 py-2 rounded-lg transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
    </div>
</div>

<!-- Financial Stats -->
<div class="grid grid-cols-3 gap-4 mb-5">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Total Billed</p>
        <p class="text-2xl font-extrabold text-slate-800"><?= cp_eur($totalBilled) ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Collected</p>
        <p class="text-2xl font-extrabold text-green-600"><?= cp_eur($totalCollected) ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Still Owed</p>
        <p class="text-2xl font-extrabold <?= $totalOwed > 0 ? 'text-red-500' : 'text-slate-400' ?>"><?= cp_eur($totalOwed) ?></p>
    </div>
</div>

<!-- Projects + Payments -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

    <!-- Projects -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Projects <span class="text-slate-400 font-normal">(<?= count($projects) ?>)</span></h2>
            <a href="index.php?page=projects&action=create" class="text-xs text-blue-600 hover:underline font-semibold">+ New</a>
        </div>
        <?php if (empty($projects)): ?>
            <p class="text-sm text-slate-400 text-center py-10">No projects yet</p>
        <?php else: ?>
        <div class="divide-y divide-slate-50">
            <?php foreach ($projects as $pr): ?>
            <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50 transition">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate"><?= htmlspecialchars($pr['title'] ?? '') ?></p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Budget: <span class="font-semibold text-slate-600"><?= cp_eur((float)($pr['budget'] ?? 0)) ?></span>
                        <?php if (!empty($pr['deadline'])): ?> · Due <?= htmlspecialchars($pr['deadline']) ?><?php endif; ?>
                    </p>
                </div>
                <?= cp_badge($pr['status'] ?? 'active') ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Payments -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Payments <span class="text-slate-400 font-normal">(<?= count($payments) ?>)</span></h2>
            <a href="index.php?page=payments&action=create" class="text-xs text-blue-600 hover:underline font-semibold">+ New</a>
        </div>
        <?php if (empty($payments)): ?>
            <p class="text-sm text-slate-400 text-center py-10">No payments yet</p>
        <?php else: ?>
        <div class="divide-y divide-slate-50">
            <?php foreach ($payments as $pm): ?>
            <div class="flex items-center gap-3 px-6 py-3 hover:bg-slate-50 transition">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold text-blue-600"><?= htmlspecialchars($pm['invoice_id'] ?? '—') ?></span>
                        <span class="text-xs text-slate-400 truncate"><?= htmlspecialchars($pm['description'] ?? '') ?></span>
                    </div>
                    <p class="text-sm font-bold text-slate-800 mt-0.5"><?= cp_eur((float)($pm['amount'] ?? 0)) ?></p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <?= cp_badge($pm['status'] ?? 'pending') ?>
                    <a href="index.php?page=payments&action=invoice&id=<?= $pm['_id'] ?>" target="_blank"
                       title="View Invoice"
                       class="p-1.5 rounded-lg bg-slate-100 hover:bg-blue-100 text-slate-500 hover:text-blue-600 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
