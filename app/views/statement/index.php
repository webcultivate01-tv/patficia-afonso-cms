<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="text-lg font-extrabold text-slate-800">Client Statement</h2>
            <p class="text-xs text-slate-400 mt-1">Generate a full account statement for any client — printable & shareable</p>
        </div>

        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="statement">
            <input type="hidden" name="action" value="view">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Select Client</label>
                <select name="client_id" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Choose a client...</option>
                    <?php foreach ($clients as $c): ?>
                    <option value="<?= $c['_id'] ?>"><?= htmlspecialchars($c['name'] ?? '') ?><?= !empty($c['company']) ? ' — ' . htmlspecialchars($c['company']) : '' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                Generate Statement
            </button>
        </form>
    </div>
</div>
