<?php
function billBadge(string $s): string {
    $map = [
        'paid'    => 'bg-green-100 text-green-700',
        'pending' => 'bg-yellow-100 text-yellow-700',
        'overdue' => 'bg-red-100 text-red-700',
    ];
    $cls = $map[strtolower($s)] ?? 'bg-gray-100 text-gray-600';
    return "<span class='inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {$cls}'>".ucfirst($s)."</span>";
}
$total     = count($bills);
$paidCount = count(array_filter($bills, fn($b) => ($b['status'] ?? '') === 'paid'));
$totalAmt  = array_sum(array_map(fn($b) => $b['amount'] ?? 0, $bills));
?>

<!-- Summary -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Total Bills</p>
        <p class="text-2xl font-bold text-gray-800"><?= $total ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Paid</p>
        <p class="text-2xl font-bold text-green-600"><?= $paidCount ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs text-gray-400 mb-1">Total Value</p>
        <p class="text-2xl font-bold text-gray-800"><?= number_format($totalAmt, 2, ',', '.') ?> €</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="px-6 py-5 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">All Bills</h2>
        <p class="text-xs text-gray-400 mt-0.5">Click "Generate Bill" to view, download or share an invoice with the client.</p>
    </div>

    <?php if (empty($bills)): ?>
        <div class="text-center py-16 text-gray-400 text-sm">No bills yet. Add payments first.</div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Due Date</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($bills as $b): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($b['client_name'] ?? '') ?></td>
                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($b['description'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-bold text-gray-800"><?= number_format($b['amount'] ?? 0, 2, ',', '.') ?> €</td>
                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($b['due_date'] ?? '—') ?></td>
                    <td class="px-6 py-4"><?= billBadge($b['status'] ?? 'pending') ?></td>
                    <td class="px-6 py-4 text-right">
                        <a href="index.php?page=payments&action=invoice&id=<?= $b['_id'] ?>" target="_blank"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-white px-3 py-1.5 rounded-lg transition"
                           style="background:#2563eb" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate Bill
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
