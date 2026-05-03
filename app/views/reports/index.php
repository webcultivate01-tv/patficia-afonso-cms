<?php function reur(float $v): string { return number_format($v,2,',','.') . ' €'; } ?>

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-extrabold text-slate-800">Financial Reports</h2>
        <p class="text-xs text-slate-400 mt-0.5">All figures computed from your payments & projects</p>
    </div>
    <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        Print Report
    </button>
</div>

<!-- Top KPI Cards -->
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <?php
    $kpis = [
        ['Total Invoiced',   reur($totalInvoiced),   '#eff6ff','#2563eb','M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Total Collected',  reur($totalCollected),  '#f0fdf4','#16a34a','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Outstanding',      reur($totalOutstanding),'#fff7ed','#ea580c','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Best Month',       $bestMonth ? reur($bestMonth['collected']) . '<br><span class="text-xs font-normal text-slate-400">' . $bestMonth['label'] . '</span>' : '—', '#fefce8','#ca8a04','M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
    ];
    foreach ($kpis as [$label, $value, $bg, $color, $icon]): ?>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?= $bg ?>">
            <svg class="w-5 h-5" style="color:<?= $color ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $icon ?>"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-0.5"><?= $label ?></p>
            <p class="text-lg font-extrabold text-slate-800 leading-tight"><?= $value ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-5">

    <!-- Monthly Revenue Chart -->
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Monthly Revenue (All Time)</h3>
        <canvas id="monthlyChart" height="90"></canvas>
    </div>

    <!-- Project Stats -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Project Overview</h3>
        <canvas id="projPieChart" width="180" height="180" class="mx-auto block mb-4"></canvas>
        <div class="space-y-2">
            <?php
            $pColors = ['active'=>['#2563eb','Active'],'completed'=>['#16a34a','Completed'],'on-hold'=>['#94a3b8','On Hold'],'cancelled'=>['#dc2626','Cancelled']];
            foreach ($pColors as $k => [$col, $lbl]): ?>
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full" style="background:<?= $col ?>"></span>
                    <span class="text-slate-600 font-medium"><?= $lbl ?></span>
                </div>
                <span class="font-bold text-slate-800"><?= $projectStats[$k] ?? 0 ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Monthly Breakdown Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-5">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="text-sm font-bold text-slate-800">Monthly Breakdown</h3>
    </div>
    <?php if (empty($monthly)): ?>
        <p class="text-sm text-slate-400 text-center py-10">No payment data yet</p>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Month</th>
                    <th class="px-6 py-3 text-right">Invoices</th>
                    <th class="px-6 py-3 text-right">Invoiced</th>
                    <th class="px-6 py-3 text-right">Collected</th>
                    <th class="px-6 py-3 text-right">Outstanding</th>
                    <th class="px-6 py-3 text-right">Collection Rate</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php foreach ($monthly as $m):
                    $rate = $m['invoiced'] > 0 ? round($m['collected'] / $m['invoiced'] * 100) : 0;
                    $outstanding = $m['invoiced'] - $m['collected'];
                ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-3 font-semibold text-slate-800"><?= $m['label'] ?></td>
                    <td class="px-6 py-3 text-right text-slate-500"><?= $m['count'] ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-slate-800"><?= reur($m['invoiced']) ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-green-600"><?= reur($m['collected']) ?></td>
                    <td class="px-6 py-3 text-right font-semibold <?= $outstanding > 0 ? 'text-orange-500' : 'text-slate-400' ?>"><?= reur($outstanding) ?></td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <div class="w-20 bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full <?= $rate >= 100 ? 'bg-green-500' : ($rate >= 50 ? 'bg-blue-500' : 'bg-orange-400') ?>" style="width:<?= $rate ?>%"></div>
                            </div>
                            <span class="text-xs font-bold text-slate-600"><?= $rate ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- Client Revenue Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="text-sm font-bold text-slate-800">Revenue by Client</h3>
    </div>
    <?php if (empty($clientTotals)): ?>
        <p class="text-sm text-slate-400 text-center py-10">No data yet</p>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-right">Invoices</th>
                    <th class="px-6 py-3 text-right">Total Invoiced</th>
                    <th class="px-6 py-3 text-right">Collected</th>
                    <th class="px-6 py-3 text-right">Outstanding</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php $rank = 1; foreach ($clientTotals as $name => $ct): ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-slate-400 w-5">#<?= $rank++ ?></span>
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0" style="background:#2563eb">
                                <?= strtoupper(substr($name, 0, 1)) ?>
                            </div>
                            <span class="font-semibold text-slate-800"><?= htmlspecialchars($name) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-right text-slate-500"><?= $ct['count'] ?></td>
                    <td class="px-6 py-3 text-right font-bold text-slate-800"><?= reur($ct['invoiced']) ?></td>
                    <td class="px-6 py-3 text-right font-semibold text-green-600"><?= reur($ct['collected']) ?></td>
                    <td class="px-6 py-3 text-right font-semibold <?= ($ct['invoiced']-$ct['collected']) > 0 ? 'text-orange-500' : 'text-slate-400' ?>"><?= reur($ct['invoiced']-$ct['collected']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>
<?php
$mLabels    = array_reverse(array_column(array_values($monthly), 'label'));
$mInvoiced  = array_reverse(array_column(array_values($monthly), 'invoiced'));
$mCollected = array_reverse(array_column(array_values($monthly), 'collected'));
?>
// Monthly chart
(function(){
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const grad = ctx.createLinearGradient(0,0,0,200);
    grad.addColorStop(0,'rgba(37,99,235,0.15)'); grad.addColorStop(1,'rgba(37,99,235,0)');
    new Chart(ctx,{type:'bar',data:{
        labels:<?= json_encode($mLabels) ?>,
        datasets:[
            {label:'Invoiced',data:<?= json_encode($mInvoiced) ?>,backgroundColor:'rgba(37,99,235,0.15)',borderColor:'#2563eb',borderWidth:1.5,borderRadius:4},
            {label:'Collected',data:<?= json_encode($mCollected) ?>,backgroundColor:'rgba(22,163,74,0.7)',borderColor:'#16a34a',borderWidth:1.5,borderRadius:4}
        ]
    },options:{responsive:true,plugins:{legend:{position:'top',labels:{font:{size:11},boxWidth:10}}},scales:{y:{beginAtZero:true,grid:{color:'#f1f5f9'},ticks:{color:'#94a3b8',font:{size:11},callback:v=>v+'€'}},x:{grid:{display:false},ticks:{color:'#94a3b8',font:{size:11}}}}}});
})();
// Project pie
(function(){
    const ctx = document.getElementById('projPieChart').getContext('2d');
    new Chart(ctx,{type:'doughnut',data:{
        labels:['Active','Completed','On Hold','Cancelled'],
        datasets:[{data:<?= json_encode(array_values($projectStats)) ?>,backgroundColor:['#2563eb','#16a34a','#94a3b8','#dc2626'],borderColor:'#fff',borderWidth:3,hoverOffset:5}]
    },options:{responsive:false,cutout:'65%',plugins:{legend:{display:false}}}});
})();
</script>
