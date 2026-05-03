<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statement — <?= htmlspecialchars($client['name'] ?? '') ?> · PAGraphics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; }
        @media print { .no-print { display:none !important; } body { background:white !important; padding:0 !important; } }
        .accent { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); }
    </style>
</head>
<body class="bg-slate-200 min-h-screen py-8 px-4">

<?php
$stmtUrl = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/index.php?page=statement&action=view&client_id=' . $client['_id'];
$phone   = preg_replace('/\D/', '', $client['phone'] ?? '');
$waMsg   = urlencode('Hi ' . ($client['name'] ?? '') . ', please find your account statement from PAGraphics here: ' . $stmtUrl);
?>

<!-- Toolbar -->
<div class="no-print max-w-3xl mx-auto flex items-center justify-between mb-5">
    <a href="index.php?page=statement" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>
    <div class="flex gap-2">
        <button onclick="copyLink()" id="copyBtn" class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-slate-50 shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 10h6a2 2 0 002-2v-8a2 2 0 00-2-2h-6a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Copy Link
        </button>
        <?php if ($phone): ?>
        <a href="https://wa.me/<?= $phone ?>?text=<?= $waMsg ?>" target="_blank"
           class="inline-flex items-center gap-2 bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Send to Client
        </a>
        <?php endif; ?>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF
        </button>
    </div>
</div>

<!-- Statement -->
<div class="bg-white max-w-3xl mx-auto rounded-2xl shadow-xl overflow-hidden">

    <!-- Header -->
    <div class="accent px-10 py-8 text-white">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-lg leading-tight">PAGraphics</p>
                        <p class="text-blue-200 text-xs">Creative Design Studio</p>
                    </div>
                </div>
                <p class="text-blue-200 text-xs">admin@pagraphics.com</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-black text-white/90">STATEMENT</p>
                <p class="text-blue-200 text-xs mt-1">Generated: <?= date('d M Y') ?></p>
            </div>
        </div>
    </div>

    <div class="px-10 py-8">

        <!-- Client Info + Summary -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Account For</p>
                <p class="text-lg font-bold text-slate-900"><?= htmlspecialchars($client['name'] ?? '') ?></p>
                <?php if (!empty($client['company'])): ?><p class="text-sm text-slate-600 font-medium"><?= htmlspecialchars($client['company']) ?></p><?php endif; ?>
                <?php if (!empty($client['email'])): ?><p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($client['email']) ?></p><?php endif; ?>
                <?php if (!empty($client['phone'])): ?><p class="text-sm text-slate-500"><?= htmlspecialchars($client['phone']) ?></p><?php endif; ?>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Account Summary</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Total Invoiced</span><span class="font-bold text-slate-800"><?= number_format($totalBilled,2,',','.') ?> €</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Total Paid</span><span class="font-bold text-green-600"><?= number_format($totalCollected,2,',','.') ?> €</span></div>
                    <hr class="border-slate-100">
                    <div class="flex justify-between">
                        <span class="font-bold text-slate-800">Balance Due</span>
                        <span class="font-extrabold text-lg <?= $balance > 0 ? 'text-red-600' : 'text-green-600' ?>"><?= number_format($balance,2,',','.') ?> €</span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-slate-100 mb-8">

        <!-- Transaction History -->
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Transaction History</p>

        <?php if (empty($payments)): ?>
        <p class="text-sm text-slate-400 text-center py-8">No transactions found for this client.</p>
        <?php else: ?>
        <table class="w-full text-sm mb-8">
            <thead><tr class="bg-slate-50">
                <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">Invoice #</th>
                <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">Description</th>
                <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">Due Date</th>
                <th class="text-right px-4 py-3 text-xs font-bold text-slate-500 uppercase">Amount</th>
                <th class="text-right px-4 py-3 text-xs font-bold text-slate-500 uppercase">Paid</th>
                <th class="text-right px-4 py-3 text-xs font-bold text-slate-500 uppercase">Balance</th>
            </tr></thead>
            <tbody>
                <?php $running = 0; foreach ($payments as $p):
                    $amt  = (float)($p['amount'] ?? 0);
                    $paid = ($p['status'] ?? '') === 'paid' ? $amt : 0;
                    $running += ($amt - $paid);
                    $sc = ['paid'=>'bg-green-100 text-green-700','pending'=>'bg-yellow-100 text-yellow-700','overdue'=>'bg-red-100 text-red-700'];
                    $cls = $sc[strtolower($p['status'] ?? '')] ?? 'bg-slate-100 text-slate-600';
                ?>
                <tr class="border-b border-slate-50">
                    <td class="px-4 py-3 font-mono text-xs font-bold text-blue-600"><?= htmlspecialchars($p['invoice_id'] ?? '—') ?></td>
                    <td class="px-4 py-3 text-slate-600 max-w-[160px] truncate"><?= htmlspecialchars($p['description'] ?? '—') ?></td>
                    <td class="px-4 py-3 text-slate-500 text-xs"><?= htmlspecialchars($p['due_date'] ?? '—') ?></td>
                    <td class="px-4 py-3 text-right font-semibold text-slate-800"><?= number_format($amt,2,',','.') ?> €</td>
                    <td class="px-4 py-3 text-right font-semibold text-green-600"><?= number_format($paid,2,',','.') ?> €</td>
                    <td class="px-4 py-3 text-right font-bold <?= $running > 0 ? 'text-red-600' : 'text-green-600' ?>"><?= number_format($running,2,',','.') ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <!-- Final Balance Box -->
        <div class="flex justify-end mb-8">
            <div class="w-64 rounded-xl p-4 <?= $balance > 0 ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' ?>">
                <p class="text-xs font-bold uppercase tracking-wide mb-1 <?= $balance > 0 ? 'text-red-500' : 'text-green-600' ?>">
                    <?= $balance > 0 ? 'Amount Outstanding' : 'Account Clear' ?>
                </p>
                <p class="text-2xl font-black <?= $balance > 0 ? 'text-red-700' : 'text-green-700' ?>"><?= number_format($balance,2,',','.') ?> €</p>
            </div>
        </div>

        <div class="bg-slate-50 rounded-xl px-6 py-4 text-xs text-slate-500 leading-relaxed">
            This statement was generated on <strong class="text-slate-700"><?= date('d M Y \a\t H:i') ?></strong> and reflects all transactions recorded in PAGraphics. For queries contact <strong class="text-slate-700">admin@pagraphics.com</strong>.
        </div>
    </div>

    <div class="accent px-10 py-4 flex justify-between items-center">
        <p class="text-blue-200 text-xs">PAGraphics · Creative Design Studio</p>
        <p class="text-blue-200 text-xs">Account Statement · <?= date('d M Y') ?></p>
    </div>
</div>

<div class="no-print h-8"></div>
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const b = document.getElementById('copyBtn');
        const o = b.innerHTML;
        b.textContent = '✓ Copied!';
        setTimeout(() => b.innerHTML = o, 2000);
    });
}
</script>
</body>
</html>
