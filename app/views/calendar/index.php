<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-extrabold text-slate-800">Calendar</h2>
        <p class="text-xs text-slate-400 mt-0.5">Project deadlines & payment due dates</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-2 text-xs">
            <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span><span class="text-slate-600 font-medium">Project Deadline</span>
            <span class="w-3 h-3 rounded-full bg-orange-400 inline-block ml-3"></span><span class="text-slate-600 font-medium">Payment Due</span>
            <span class="w-3 h-3 rounded-full bg-red-500 inline-block ml-3"></span><span class="text-slate-600 font-medium">Overdue</span>
        </div>
        <div class="flex gap-1">
            <button onclick="prevMonth()" class="p-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="goToday()" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">Today</button>
            <button onclick="nextMonth()" class="p-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- Month Title -->
<div class="text-center mb-4">
    <h3 id="monthTitle" class="text-lg font-extrabold text-slate-800"></h3>
</div>

<!-- Calendar Grid -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <!-- Day headers -->
    <div class="grid grid-cols-7 border-b border-slate-100">
        <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d): ?>
        <div class="py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wide"><?= $d ?></div>
        <?php endforeach; ?>
    </div>
    <!-- Days -->
    <div id="calGrid" class="grid grid-cols-7"></div>
</div>

<!-- Event Detail Panel -->
<div id="eventPanel" class="hidden mt-4 bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
    <h4 class="text-sm font-bold text-slate-800 mb-3" id="panelDate"></h4>
    <div id="panelEvents" class="space-y-2"></div>
</div>

<script>
const allEvents = <?= json_encode(array_values($events)) ?>;
const today = new Date();
let current = new Date(today.getFullYear(), today.getMonth(), 1);

function buildEventMap() {
    const map = {};
    allEvents.forEach(e => {
        if (!e.date) return;
        const d = e.date.substring(0, 10);
        if (!map[d]) map[d] = [];
        map[d].push(e);
    });
    return map;
}

function render() {
    const map   = buildEventMap();
    const year  = current.getFullYear();
    const month = current.getMonth();
    const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('monthTitle').textContent = monthNames[month] + ' ' + year;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const todayStr = today.toISOString().substring(0, 10);

    let html = '';
    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) html += '<div class="min-h-[90px] border-b border-r border-slate-50 p-1 bg-slate-50/50"></div>';

    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = year + '-' + String(month+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
        const isToday = dateStr === todayStr;
        const isPast  = dateStr < todayStr;
        const evs     = map[dateStr] || [];
        const hasOverdue = evs.some(e => e.status === 'overdue' || (e.type === 'payment' && e.status !== 'paid' && isPast));

        html += `<div class="min-h-[90px] border-b border-r border-slate-50 p-1.5 cursor-pointer hover:bg-blue-50/40 transition ${isToday ? 'bg-blue-50' : ''}" onclick="showEvents('${dateStr}')">`;
        html += `<div class="flex items-center justify-between mb-1">`;
        html += `<span class="text-xs font-bold ${isToday ? 'bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center' : (isPast ? 'text-slate-300' : 'text-slate-700')}">${d}</span>`;
        if (hasOverdue) html += `<span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>`;
        html += `</div>`;

        evs.slice(0, 2).forEach(e => {
            const isOver = e.status === 'overdue' || (e.type === 'payment' && e.status !== 'paid' && isPast);
            const dot = e.type === 'project' ? 'bg-blue-500' : (isOver ? 'bg-red-500' : 'bg-orange-400');
            html += `<div class="flex items-start gap-1 mb-0.5">
                <span class="w-1.5 h-1.5 rounded-full ${dot} flex-shrink-0 mt-1"></span>
                <span class="text-xs text-slate-600 leading-tight truncate">${e.title}</span>
            </div>`;
        });
        if (evs.length > 2) html += `<span class="text-xs text-blue-500 font-semibold">+${evs.length - 2} more</span>`;
        html += '</div>';
    }

    // Fill remaining cells
    const totalCells = firstDay + daysInMonth;
    const remainder  = totalCells % 7;
    if (remainder > 0) {
        for (let i = 0; i < 7 - remainder; i++) html += '<div class="min-h-[90px] border-b border-r border-slate-50 p-1 bg-slate-50/50"></div>';
    }

    document.getElementById('calGrid').innerHTML = html;
    document.getElementById('eventPanel').classList.add('hidden');
}

function showEvents(dateStr) {
    const map  = buildEventMap();
    const evs  = map[dateStr] || [];
    if (!evs.length) { document.getElementById('eventPanel').classList.add('hidden'); return; }

    const [y, m, d] = dateStr.split('-');
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    document.getElementById('panelDate').textContent = d + ' ' + months[parseInt(m)-1] + ' ' + y + ' — ' + evs.length + ' event' + (evs.length > 1 ? 's' : '');

    const todayStr = new Date().toISOString().substring(0, 10);
    const isPast   = dateStr < todayStr;

    document.getElementById('panelEvents').innerHTML = evs.map(e => {
        const isOver = e.status === 'overdue' || (e.type === 'payment' && e.status !== 'paid' && isPast);
        const bg  = e.type === 'project' ? 'bg-blue-50 border-blue-200' : (isOver ? 'bg-red-50 border-red-200' : 'bg-orange-50 border-orange-200');
        const dot = e.type === 'project' ? 'bg-blue-500' : (isOver ? 'bg-red-500' : 'bg-orange-400');
        return `<div class="flex items-start gap-3 p-3 rounded-xl border ${bg}">
            <span class="w-2 h-2 rounded-full ${dot} flex-shrink-0 mt-1.5"></span>
            <div>
                <p class="text-sm font-semibold text-slate-800">${e.title}</p>
                <p class="text-xs text-slate-500 mt-0.5">${e.sub}</p>
            </div>
        </div>`;
    }).join('');

    document.getElementById('eventPanel').classList.remove('hidden');
}

function prevMonth() { current.setMonth(current.getMonth() - 1); render(); }
function nextMonth() { current.setMonth(current.getMonth() + 1); render(); }
function goToday()   { current = new Date(today.getFullYear(), today.getMonth(), 1); render(); }

render();
</script>
