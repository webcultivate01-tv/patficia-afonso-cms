<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= htmlspecialchars($payment['invoice_id'] ?? '') ?> — PAGraphics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .invoice-wrap { box-shadow: none !important; border: none !important; border-radius: 0 !important; max-width: 100% !important; }
            .page-bg { background: white !important; padding: 0 !important; }
        }

        .invoice-accent { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); }
        .watermark {
            position: absolute; bottom: 40px; right: 40px;
            font-size: 5rem; font-weight: 900; color: rgba(37,99,235,0.04);
            letter-spacing: -2px; pointer-events: none; user-select: none;
        }
        .divider { border: none; border-top: 1px solid #e2e8f0; }
        .row-stripe:nth-child(even) { background: #f8fafc; }
    </style>
</head>
<body class="page-bg bg-slate-200 min-h-screen py-8 px-4">

<?php
$invoiceNo  = $payment['invoice_id'] ?? strtoupper(substr((string)$payment['_id'], -8));
$total      = (float)($payment['amount'] ?? 0);
$advanced   = (float)($payment['advanced_payment'] ?? 0);
$remaining  = (float)($payment['remaining'] ?? ($total - $advanced));
$status     = strtolower($payment['status'] ?? 'pending');
$paidAt     = $payment['paid_at'] ?? null;
$dueDate    = $payment['due_date'] ?? null;
$createdAt  = null;
if (!empty($payment['created_at'])) {
    try {
        $ms = (int)(string)$payment['created_at'];
        $createdAt = date('d M Y · H:i', intdiv($ms, 1000));
    } catch (\Exception $e) {}
}
$statusCfg = [
    'paid'    => ['bg' => '#dcfce7', 'color' => '#15803d', 'label' => 'PAID'],
    'pending' => ['bg' => '#fef9c3', 'color' => '#a16207', 'label' => 'PENDING'],
    'overdue' => ['bg' => '#fee2e2', 'color' => '#b91c1c', 'label' => 'OVERDUE'],
];
$sc = $statusCfg[$status] ?? $statusCfg['pending'];
?>

<!-- Toolbar -->
<div class="no-print max-w-3xl mx-auto flex items-center justify-between mb-5">
    <a href="index.php?page=bills" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Bills
    </a>
    <div class="flex gap-2">
        <button onclick="copyLink()" id="copyBtn"
                class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-slate-50 shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-4 10h6a2 2 0 002-2v-8a2 2 0 00-2-2h-6a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            Copy Link
        </button>
        <a id="waBtn" href="#" target="_blank"
           class="inline-flex items-center gap-2 bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.845L.057 23.428a.5.5 0 00.609.61l5.652-1.48A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.015-1.376l-.36-.214-3.733.978.997-3.645-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
            WhatsApp
        </a>
        <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download PDF
        </button>
    </div>
</div>

<!-- Invoice -->
<div class="invoice-wrap relative bg-white max-w-3xl mx-auto rounded-2xl shadow-xl overflow-hidden">

    <!-- Top accent bar -->
    <div class="invoice-accent px-10 py-8 text-white">
        <div class="flex justify-between items-start">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-lg leading-tight">PAGraphics</p>
                        <p class="text-blue-200 text-xs">Creative Design Studio</p>
                    </div>
                </div>
                <p class="text-blue-200 text-xs">admin@pagraphics.com</p>
                <p class="text-blue-200 text-xs">www.pagraphics.com</p>
            </div>
            <!-- Invoice title + status -->
            <div class="text-right">
                <p class="text-4xl font-black tracking-tight text-white/90">INVOICE</p>
                <p class="text-blue-200 text-sm mt-1 font-mono"># <?= $invoiceNo ?></p>
                <?php if ($createdAt): ?>
                <p class="text-blue-200 text-xs mt-1">Issued: <?= $createdAt ?></p>
                <?php endif; ?>
                <div class="mt-3 inline-block px-4 py-1.5 rounded-full text-xs font-black tracking-widest"
                     style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>">
                    <?= $sc['label'] ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="px-10 py-8 relative">
        <div class="watermark">PD</div>

        <!-- Bill To / Project Info -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <!-- Client Details -->
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Bill To</p>
                <p class="text-lg font-bold text-slate-900"><?= htmlspecialchars($client['name'] ?? $payment['client_name'] ?? '') ?></p>
                <?php if (!empty($client['company'])): ?>
                <p class="text-sm text-slate-600 font-medium"><?= htmlspecialchars($client['company']) ?></p>
                <?php endif; ?>
                <?php if (!empty($client['email'])): ?>
                <p class="text-sm text-slate-500 mt-1 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <?= htmlspecialchars($client['email']) ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($client['phone'])): ?>
                <p class="text-sm text-slate-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <?= htmlspecialchars($client['phone']) ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Payment Dates -->
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Payment Info</p>
                <?php if ($dueDate): ?>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Due Date</span>
                    <span class="font-semibold text-slate-800"><?= htmlspecialchars($dueDate) ?></span>
                </div>
                <?php endif; ?>
                <?php if ($paidAt): ?>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Paid On</span>
                    <span class="font-semibold text-green-700"><?= htmlspecialchars($paidAt) ?></span>
                </div>
                <?php endif; ?>
                <?php if ($project): ?>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-slate-500">Project</span>
                    <span class="font-semibold text-slate-800"><?= htmlspecialchars($project['title'] ?? '') ?></span>
                </div>
                <?php if (!empty($project['deadline'])): ?>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Deadline</span>
                    <span class="font-semibold text-slate-800"><?= htmlspecialchars($project['deadline']) ?></span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <hr class="divider mb-8">

        <!-- Services Table -->
        <?php if (!empty($billServices)): ?>
        <div class="mb-8">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Services</p>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 rounded-lg">
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wide rounded-l-lg">#</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wide">Service</th>
                        <th class="text-left px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wide">Description</th>
                        <th class="text-right px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wide rounded-r-lg">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($billServices as $sv): ?>
                    <tr class="row-stripe border-b border-slate-50">
                        <td class="px-4 py-3 text-slate-400 font-mono text-xs"><?= $i++ ?></td>
                        <td class="px-4 py-3 font-semibold text-slate-800"><?= htmlspecialchars($sv['name'] ?? '') ?></td>
                        <td class="px-4 py-3 text-slate-500"><?= htmlspecialchars($sv['description'] ?? '—') ?></td>
                        <td class="px-4 py-3 text-right font-bold text-slate-800"><?= number_format($sv['price'] ?? 0, 2, ',', '.') ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- Description row if no services -->
        <?php if (empty($billServices) && !empty($payment['description'])): ?>
        <div class="mb-8">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</p>
            <div class="bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700">
                <?= htmlspecialchars($payment['description']) ?>
            </div>
        </div>
        <?php endif; ?>

        <hr class="divider mb-6">

        <!-- Payment Breakdown -->
        <div class="flex justify-end mb-8">
            <div class="w-72 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Total Project Cost</span>
                    <span class="font-semibold text-slate-800"><?= number_format($total, 2, ',', '.') ?> €</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Advanced Payment</span>
                    <span class="font-semibold text-green-600">− <?= number_format($advanced, 2, ',', '.') ?> €</span>
                </div>
                <hr class="divider my-1">
                <div class="flex justify-between items-center pt-1">
                    <span class="font-bold text-slate-800">Remaining Balance</span>
                    <span class="text-xl font-black <?= $remaining <= 0 ? 'text-green-600' : 'text-blue-700' ?>">
                        <?= number_format($remaining, 2, ',', '.') ?> €
                    </span>
                </div>
                <?php if ($remaining <= 0): ?>
                <div class="text-center mt-2">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">✓ Fully Paid</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="mt-8 border border-slate-200 rounded-xl p-6">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Terms &amp; Conditions</p>
            <ol class="space-y-1.5 text-xs text-slate-500 list-decimal list-inside leading-relaxed">
                <li>Payment is due within <strong class="text-slate-700">7 days</strong> of the invoice date unless otherwise agreed in writing.</li>
                <li>The advanced payment is <strong class="text-slate-700">non-refundable</strong> once project work has commenced.</li>
                <li>Final deliverables will only be released upon receipt of the <strong class="text-slate-700">full remaining balance</strong>.</li>
                <li>Any revision requests beyond the agreed scope will be quoted and billed separately.</li>
                <li>PatriDesigns retains the right to showcase completed work in its portfolio unless a confidentiality agreement is in place.</li>
                <li>Late payments may incur an additional fee of <strong class="text-slate-700">2% per month</strong> on the outstanding balance.</li>
                <li>All disputes shall be resolved under the jurisdiction of the applicable local laws.</li>
            </ol>
        </div>

        <!-- Footer note -->
        <div class="bg-slate-50 rounded-xl px-6 py-4 flex items-start gap-3 mt-6">
            <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-slate-500 leading-relaxed">
                Thank you for choosing <strong class="text-slate-700">PAGraphics</strong>. For any questions regarding this invoice, please contact us at <strong class="text-slate-700">admin@pagraphics.com</strong>.
            </p>
        </div>
    </div>

    <!-- Bottom bar -->
    <div class="invoice-accent px-10 py-4 flex justify-between items-center">
        <p class="text-blue-200 text-xs">PAGraphics · Creative Design Studio</p>
        <p class="text-blue-200 text-xs font-mono">INV-<?= $invoiceNo ?></p>
    </div>
</div>

<div class="no-print h-8"></div>

<script>
const invoiceUrl = window.location.href;
const clientName = <?= json_encode($client['name'] ?? $payment['client_name'] ?? '') ?>;
const msg = encodeURIComponent('Hi ' + clientName + ', please find your invoice from PAGraphics here: ' + invoiceUrl);
document.getElementById('waBtn').href = 'https://wa.me/?text=' + msg;

function copyLink() {
    navigator.clipboard.writeText(invoiceUrl).then(() => {
        const btn = document.getElementById('copyBtn');
        const orig = btn.innerHTML;
        btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied!';
        btn.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
        setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('bg-green-50','text-green-700','border-green-200'); }, 2500);
    });
}
</script>
</body>
</html>
