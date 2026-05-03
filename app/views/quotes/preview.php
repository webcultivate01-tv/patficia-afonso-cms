<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote — <?= htmlspecialchars($quote['client_name'] ?? '') ?> · PAGraphics</title>
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
$total    = (float)($quote['amount'] ?? 0);
$advanced = (float)($quote['advanced_payment'] ?? 0);
$remaining = $total - $advanced;
$createdAt = null;
if (!empty($quote['created_at'])) {
    try { $createdAt = date('d M Y', intdiv((int)(string)$quote['created_at'], 1000)); } catch (\Exception $e) {}
}
?>

<!-- Toolbar -->
<div class="no-print max-w-3xl mx-auto flex items-center justify-between mb-5">
    <a href="index.php?page=quotes" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Quotes
    </a>
    <div class="flex gap-2">
        <button onclick="copyLink()" id="copyBtn" class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-slate-50 shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 10h6a2 2 0 002-2v-8a2 2 0 00-2-2h-6a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Copy Link
        </button>
        <a id="waBtn" href="#" target="_blank" class="inline-flex items-center gap-2 bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            WhatsApp
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF
        </button>
    </div>
</div>

<!-- Quote Card -->
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
                <p class="text-blue-200 text-xs">www.pagraphics.com</p>
            </div>
            <div class="text-right">
                <p class="text-4xl font-black tracking-tight text-white/90">QUOTE</p>
                <p class="text-blue-200 text-xs mt-1">Issued: <?= $createdAt ?? date('d M Y') ?></p>
                <?php if (!empty($quote['valid_until'])): ?>
                <p class="text-blue-200 text-xs">Valid Until: <?= htmlspecialchars($quote['valid_until']) ?></p>
                <?php endif; ?>
                <div class="mt-3 inline-block px-4 py-1.5 rounded-full text-xs font-black tracking-widest bg-yellow-100 text-yellow-800">
                    QUOTE
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="px-10 py-8">

        <!-- Client + Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Prepared For</p>
                <p class="text-lg font-bold text-slate-900"><?= htmlspecialchars($client['name'] ?? $quote['client_name'] ?? '') ?></p>
                <?php if (!empty($client['company'])): ?><p class="text-sm text-slate-600 font-medium"><?= htmlspecialchars($client['company']) ?></p><?php endif; ?>
                <?php if (!empty($client['email'])): ?><p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($client['email']) ?></p><?php endif; ?>
                <?php if (!empty($client['phone'])): ?><p class="text-sm text-slate-500"><?= htmlspecialchars($client['phone']) ?></p><?php endif; ?>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Quote Details</p>
                <div class="space-y-1.5 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500">Date</span><span class="font-semibold text-slate-800"><?= $createdAt ?? date('d M Y') ?></span></div>
                    <?php if (!empty($quote['valid_until'])): ?>
                    <div class="flex justify-between"><span class="text-slate-500">Valid Until</span><span class="font-semibold text-slate-800"><?= htmlspecialchars($quote['valid_until']) ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="border-slate-100 mb-8">

        <!-- Services -->
        <?php if (!empty($billServices)): ?>
        <div class="mb-8">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Services</p>
            <table class="w-full text-sm">
                <thead><tr class="bg-slate-50">
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">Service</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase">Description</th>
                    <th class="text-right px-4 py-3 text-xs font-bold text-slate-500 uppercase">Price</th>
                </tr></thead>
                <tbody>
                    <?php $i=1; foreach ($billServices as $sv): ?>
                    <tr class="border-b border-slate-50">
                        <td class="px-4 py-3 text-slate-400 font-mono text-xs"><?= $i++ ?></td>
                        <td class="px-4 py-3 font-semibold text-slate-800"><?= htmlspecialchars($sv['name'] ?? '') ?></td>
                        <td class="px-4 py-3 text-slate-500"><?= htmlspecialchars($sv['description'] ?? '—') ?></td>
                        <td class="px-4 py-3 text-right font-bold text-slate-800"><?= number_format($sv['price'] ?? 0, 2, ',', '.') ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php elseif (!empty($quote['description'])): ?>
        <div class="mb-8">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</p>
            <div class="bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700"><?= htmlspecialchars($quote['description']) ?></div>
        </div>
        <?php endif; ?>

        <hr class="border-slate-100 mb-6">

        <!-- Totals -->
        <div class="flex justify-end mb-8">
            <div class="w-72 space-y-2">
                <div class="flex justify-between text-sm"><span class="text-slate-500">Total Project Cost</span><span class="font-semibold text-slate-800"><?= number_format($total,2,',','.') ?> €</span></div>
                <div class="flex justify-between text-sm"><span class="text-slate-500">Advanced Payment</span><span class="font-semibold text-green-600">− <?= number_format($advanced,2,',','.') ?> €</span></div>
                <hr class="border-slate-200">
                <div class="flex justify-between items-center pt-1">
                    <span class="font-bold text-slate-800">Remaining Balance</span>
                    <span class="text-xl font-black text-blue-700"><?= number_format($remaining,2,',','.') ?> €</span>
                </div>
            </div>
        </div>

        <?php if (!empty($quote['notes'])): ?>
        <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-4 mb-6">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">Notes</p>
            <p class="text-sm text-slate-700"><?= nl2br(htmlspecialchars($quote['notes'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="bg-slate-50 rounded-xl px-6 py-4 flex items-start gap-3">
            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-xs text-slate-500 leading-relaxed">This is a quote, not an invoice. Prices are valid until the date stated above. To accept, please reply or contact us at <strong class="text-slate-700">admin@pagraphics.com</strong>.</p>
        </div>
    </div>

    <div class="accent px-10 py-4 flex justify-between items-center">
        <p class="text-blue-200 text-xs">PAGraphics · Creative Design Studio</p>
        <p class="text-blue-200 text-xs">Quote · <?= $createdAt ?? date('d M Y') ?></p>
    </div>
</div>

<div class="no-print h-8"></div>
<script>
const url = window.location.href;
const name = <?= json_encode($client['name'] ?? $quote['client_name'] ?? '') ?>;
document.getElementById('waBtn').href = 'https://wa.me/?text=' + encodeURIComponent('Hi ' + name + ', please find your quote from PAGraphics here: ' + url);
function copyLink() {
    navigator.clipboard.writeText(url).then(() => {
        const b = document.getElementById('copyBtn');
        const o = b.innerHTML;
        b.textContent = '✓ Copied!';
        setTimeout(() => b.innerHTML = o, 2000);
    });
}
</script>
</body>
</html>
