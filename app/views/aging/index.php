<?php
function ageur(float $v): string { return number_format($v,2,',','.') . ' €'; }
$bucketCfg = [
    'current' => ['Not Yet Due',    'bg-blue-50 border-blue-200',   'text-blue-700',   'bg-blue-500'],
    '1_30'    => ['1 – 30 Days',    'bg-yellow-50 border-yellow-200','text-yellow-700', 'bg-yellow-400'],
    '31_60'   => ['31 – 60 Days',   'bg-orange-50 border-orange-200','text-orange-700', 'bg-orange-500'],
    '61_90'   => ['61 – 90 Days',   'bg-red-50 border-red-200',     'text-red-700',    'bg-red-500'],
    '90plus'  => ['Over 90 Days',   'bg-red-100 border-red-300',    'text-red-800',    'bg-red-700'],
];
?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-extrabold text-slate-800">Invoice Aging</h2>
        <p class="text-xs text-slate-400 mt-0.5">All unpaid invoices grouped by how overdue they are</p>
    </div>
    <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print
    </button>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-5 gap-3 mb-6">
    <?php foreach ($bucketCfg as $key => [$label, $cardCls, $textCls, $dotCls]): ?>
    <div class="bg-white rounded-2xl border <?= $cardCls ?> p-4 text-center">
        <p class="text-xs font-semibold text-slate-500 mb-1"><?= $label ?></p>
        <p class="text-xl font-extrabold <?= $textCls ?>"><?= ageur($totals[$key] ?? 0) ?></p>
        <p class="text-xs text-slate-400 mt-0.5"><?= count($buckets[$key]) ?> invoice<?= count($buckets[$key]) !== 1 ? 's' : '' ?></p>
    </div>
    <?php endforeach; ?>
</div>

<!-- Grand Total Bar -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <div class="flex items-center justify-between mb-3">
        <p class="text-sm font-bold text-slate-800">Total Outstanding</p>
        <p class="text-xl font-extrabold text-red-600"><?= ageur($grandTotal) ?></p>
    </div>
    <?php if ($grandTotal > 0): ?>
    <div class="flex h-3 rounded-full overflow-hidden gap-0.5">
        <?php foreach ($bucketCfg as $key => [$label, $cardCls, $textCls, $dotCls]):
            $pct = $grandTotal > 0 ? ($totals[$key] / $grandTotal * 100) : 0;
            if ($pct < 1) continue;
        ?>
        <div class="<?= $dotCls ?> h-full rounded-full transition-all" style="width:<?= $pct ?>%" title="<?= $label ?>: <?= ageur($totals[$key]) ?>"></div>
        <?php endforeach; ?>
    </div>
    <div class="flex flex-wrap gap-3 mt-2">
        <?php foreach ($bucketCfg as $key => [$label, $cardCls, $textCls, $dotCls]):
            if (!($totals[$key] ?? 0)) continue; ?>
        <div class="flex items-center gap-1.5 text-xs text-slate-500">
            <span class="w-2 h-2 rounded-full <?= $dotCls ?>"></span><?= $label ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Bucket Tables -->
<?php foreach ($bucketCfg as $key => [$label, $cardCls, $textCls, $dotCls]):
    if (empty($buckets[$key])) continue; ?>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-4">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full <?= $dotCls ?>"></span>
            <h3 class="text-sm font-bold text-slate-800"><?= $label ?></h3>
            <span class="text-xs text-slate-400">(<?= count($buckets[$key]) ?>)</span>
        </div>
        <span class="text-sm font-extrabold <?= $textCls ?>"><?= ageur($totals[$key]) ?></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                <th class="px-6 py-3 text-left">Invoice #</th>
                <th class="px-6 py-3 text-left">Client</th>
                <th class="px-6 py-3 text-left">Description</th>
                <th class="px-6 py-3 text-left">Due Date</th>
                <th class="px-6 py-3 text-right">Amount Due</th>
                <th class="px-6 py-3 text-right">Action</th>
            </tr></thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($buckets[$key] as $p):
                    $phone   = preg_replace('/\D/', '', $p['client_phone'] ?? '');
                    $chaseMsg = urlencode('Hi ' . ($p['client_name'] ?? '') . ', this is a reminder that invoice #' . ($p['invoice_id'] ?? '') . ' for ' . number_format($p['amount'] ?? 0, 2, ',', '.') . ' € is outstanding. Please arrange payment. — PAGraphics');
                ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-3 font-mono text-xs font-bold text-blue-600"><?= htmlspecialchars($p['invoice_id'] ?? '—') ?></td>
                    <td class="px-6 py-3 font-semibold text-slate-800"><?= htmlspecialchars($p['client_name'] ?? '') ?></td>
                    <td class="px-6 py-3 text-slate-500 max-w-[140px] truncate"><?= htmlspecialchars($p['description'] ?? '—') ?></td>
                    <td class="px-6 py-3 text-slate-500"><?= htmlspecialchars($p['due_date'] ?? '—') ?></td>
                    <td class="px-6 py-3 text-right font-bold <?= $textCls ?>"><?= ageur((float)($p['remaining'] ?? $p['amount'] ?? 0)) ?></td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <a href="index.php?page=payments&action=invoice&id=<?= $p['_id'] ?>" target="_blank"
                               class="text-xs font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg transition">Bill</a>
                            <a href="https://wa.me/?text=<?= $chaseMsg ?>" target="_blank"
                               class="text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1.5 rounded-lg transition">Chase</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<?php if ($grandTotal == 0): ?>
<div class="text-center py-20 text-slate-400">
    <svg class="w-14 h-14 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <p class="text-sm font-semibold">All invoices are paid! 🎉</p>
</div>
<?php endif; ?>
