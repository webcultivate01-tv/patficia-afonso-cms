<?php
$statusMap = [
    'draft'    => 'bg-slate-100 text-slate-600',
    'sent'     => 'bg-blue-100 text-blue-700',
    'approved' => 'bg-green-100 text-green-700',
    'rejected' => 'bg-red-100 text-red-700',
];
$total = count($quotes);
$approved = count(array_filter($quotes, fn($q) => ($q['quote_status'] ?? '') === 'approved'));
$pending  = count(array_filter($quotes, fn($q) => in_array($q['quote_status'] ?? '', ['draft','sent'])));
$totalValue = array_sum(array_map(fn($q) => (float)($q['amount'] ?? 0), $quotes));
?>

<!-- Summary -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs text-slate-400 mb-1">Total Quotes</p>
        <p class="text-2xl font-extrabold text-slate-800"><?= $total ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs text-slate-400 mb-1">Approved</p>
        <p class="text-2xl font-extrabold text-green-600"><?= $approved ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs text-slate-400 mb-1">Pending</p>
        <p class="text-2xl font-extrabold text-blue-600"><?= $pending ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <p class="text-xs text-slate-400 mb-1">Total Value</p>
        <p class="text-2xl font-extrabold text-slate-800"><?= number_format($totalValue,2,',','.') ?> €</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100">
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
        <div>
            <h2 class="font-bold text-slate-800">Quotes</h2>
            <p class="text-xs text-slate-400 mt-0.5">Create a price quote to send to a client before they pay</p>
        </div>
        <a href="index.php?page=quotes&action=create"
           class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-lg transition" style="background:#2563eb" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Quote
        </a>
    </div>

    <?php if (empty($quotes)): ?>
        <div class="text-center py-16 text-slate-400 text-sm">No quotes yet. Create your first one!</div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Valid Until</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($quotes as $q):
                    $qs  = $q['quote_status'] ?? 'draft';
                    $cls = $statusMap[$qs] ?? 'bg-slate-100 text-slate-600';
                    $phone = preg_replace('/\D/', '', $q['client_phone'] ?? '');
                    $previewUrl = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/index.php?page=quotes&action=preview&id=' . $q['_id'];
                    $waMsg = urlencode('Hi ' . ($q['client_name'] ?? '') . ', please find your quote from PAGraphics here: ' . $previewUrl);
                ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($q['client_name'] ?? '') ?></td>
                    <td class="px-6 py-4 text-slate-500 max-w-[160px] truncate"><?= htmlspecialchars($q['description'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-bold text-slate-800"><?= number_format($q['amount'] ?? 0, 2, ',', '.') ?> €</td>
                    <td class="px-6 py-4 text-slate-500"><?= htmlspecialchars($q['valid_until'] ?? '—') ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $cls ?>"><?= ucfirst($qs) ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1.5 flex-wrap">
                            <!-- Preview -->
                            <a href="index.php?page=quotes&action=preview&id=<?= $q['_id'] ?>" target="_blank"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1.5 rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview
                            </a>
                            <!-- Send via WhatsApp -->
                            <a href="https://wa.me/?text=<?= $waMsg ?>" target="_blank"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1.5 rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                                Send
                            </a>
                            <?php if ($qs !== 'approved'): ?>
                            <!-- Approve → convert to payment -->
                            <a href="index.php?page=quotes&action=approve&id=<?= $q['_id'] ?>"
                               onclick="return confirm('Approve this quote and convert it to a payment?')"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Approve
                            </a>
                            <?php endif; ?>
                            <!-- Edit -->
                            <a href="index.php?page=quotes&action=edit&id=<?= $q['_id'] ?>"
                               class="text-xs text-blue-600 hover:text-blue-800 font-medium px-2 py-1.5">Edit</a>
                            <!-- Delete -->
                            <a href="index.php?page=quotes&action=delete&id=<?= $q['_id'] ?>"
                               onclick="return confirm('Delete this quote?')"
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
