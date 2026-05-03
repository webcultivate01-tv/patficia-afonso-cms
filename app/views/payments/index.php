<?php
function badge(string $s): string {
    $map = [
        'paid'    => 'bg-green-100 text-green-700',
        'pending' => 'bg-yellow-100 text-yellow-700',
        'overdue' => 'bg-red-100 text-red-700',
    ];
    $cls = $map[strtolower($s)] ?? 'bg-gray-100 text-gray-600';
    return "<span class='inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {$cls}'>".ucfirst($s)."</span>";
}
$total = array_sum(array_map(fn($p) => $p['amount'] ?? 0, $payments));
$paid  = array_sum(array_map(fn($p) => ($p['status'] ?? '') === 'paid' ? ($p['amount'] ?? 0) : 0, $payments));
$overdue = array_filter($payments, fn($p) => ($p['status'] ?? '') === 'overdue');
?>

<!-- Summary -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Total Invoiced</p>
        <p class="text-2xl font-bold text-gray-800"><?= number_format($total, 2, ',', '.') ?> €</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Collected</p>
        <p class="text-2xl font-bold text-green-600"><?= number_format($paid, 2, ',', '.') ?> €</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Outstanding</p>
        <p class="text-2xl font-bold text-orange-500"><?= number_format($total - $paid, 2, ',', '.') ?> €</p>
    </div>
    <div class="bg-white rounded-2xl border <?= count($overdue) > 0 ? 'border-red-200 bg-red-50' : 'border-gray-100' ?> shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Overdue</p>
        <p class="text-2xl font-bold text-red-600"><?= count($overdue) ?></p>
    </div>
</div>

<?php if (count($overdue) > 0): ?>
<!-- Overdue Alert Banner -->
<div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-5">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <p class="text-sm font-semibold text-red-700">
        <?= count($overdue) ?> overdue payment<?= count($overdue) > 1 ? 's' : '' ?> need your attention — chase them using the
        <svg class="w-3.5 h-3.5 inline text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
        Chase button on each row below.
    </p>
</div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">All Payments</h2>
        <a href="index.php?page=payments&action=create"
           class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-lg transition" style="background:#2563eb" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Payment
        </a>
    </div>

    <?php if (empty($payments)): ?>
        <div class="text-center py-16 text-gray-400 text-sm">No payments recorded yet.</div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Invoice #</th>
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Remaining</th>
                    <th class="px-6 py-3 text-left">Due Date</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($payments as $p):
                    $isOverdue = ($p['status'] ?? '') === 'overdue';
                    $rowBg     = $isOverdue ? 'bg-red-50/60' : '';
                    $phone     = preg_replace('/\D/', '', $p['client_phone'] ?? '');
                    $invoiceUrl = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/index.php?page=payments&action=invoice&id=' . $p['_id'];
                    $chaseMsg  = urlencode('Hi ' . ($p['client_name'] ?? '') . ', this is a reminder that invoice #' . ($p['invoice_id'] ?? '') . ' for ' . number_format($p['amount'] ?? 0, 2, ',', '.') . ' € is overdue. Please arrange payment at your earliest convenience. — PAGraphics');
                    $shareMsg  = urlencode('Hi ' . ($p['client_name'] ?? '') . ', please find your invoice #' . ($p['invoice_id'] ?? '') . ' from PAGraphics here: ' . $invoiceUrl);
                ?>
                <tr class="<?= $rowBg ?> hover:bg-gray-50 transition <?= $isOverdue ? 'border-l-4 border-red-400' : '' ?>">
                    <td class="px-6 py-4 font-mono text-xs font-bold text-blue-600"><?= htmlspecialchars($p['invoice_id'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($p['client_name'] ?? '') ?></td>
                    <td class="px-6 py-4 text-gray-500 max-w-[140px] truncate"><?= htmlspecialchars($p['description'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-bold text-gray-800"><?= number_format($p['amount'] ?? 0, 2, ',', '.') ?> €</td>
                    <td class="px-6 py-4 font-semibold <?= ($p['remaining'] ?? 0) > 0 ? 'text-orange-600' : 'text-green-600' ?>">
                        <?= number_format($p['remaining'] ?? 0, 2, ',', '.') ?> €
                    </td>
                    <td class="px-6 py-4 <?= $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-500' ?>"><?= htmlspecialchars($p['due_date'] ?? '—') ?></td>
                    <td class="px-6 py-4"><?= badge($p['status'] ?? 'pending') ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                            <!-- Invoice -->
                            <a href="index.php?page=payments&action=invoice&id=<?= $p['_id'] ?>" target="_blank"
                               title="View Invoice"
                               class="inline-flex items-center gap-1 text-xs text-emerald-600 hover:text-emerald-800 font-semibold px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Bill
                            </a>
                            <!-- Share invoice via WhatsApp -->
                            <a href="https://wa.me/?text=<?= $shareMsg ?>" target="_blank"
                               title="Share Invoice via WhatsApp"
                               class="inline-flex items-center gap-1 text-xs text-green-600 hover:text-green-800 font-semibold px-2.5 py-1.5 rounded-lg bg-green-50 hover:bg-green-100 transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                                Send
                            </a>
                            <?php if ($isOverdue): ?>
                            <!-- Chase overdue via WhatsApp -->
                            <a href="https://wa.me/?text=<?= $chaseMsg ?>" target="_blank"
                               title="Chase overdue payment"
                               class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-800 font-semibold px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                Chase
                            </a>
                            <?php endif; ?>
                            <!-- Edit -->
                            <a href="index.php?page=payments&action=edit&id=<?= $p['_id'] ?>"
                               class="text-xs text-blue-600 hover:text-blue-800 font-medium px-2 py-1.5">Edit</a>
                            <!-- Delete -->
                            <a href="index.php?page=payments&action=delete&id=<?= $p['_id'] ?>"
                               onclick="return confirm('Delete this payment?')"
                               class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1.5">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
