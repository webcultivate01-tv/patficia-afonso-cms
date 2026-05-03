<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h2 class="text-lg font-bold text-slate-800 mb-6"><?= $quote ? 'Edit Quote' : 'New Quote' ?></h2>

        <form method="POST" action="index.php?page=quotes&action=<?= $action ?>" class="space-y-5">
            <?php if ($quote): ?>
                <input type="hidden" name="id" value="<?= $quote['_id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Client *</label>
                <select name="client_id" id="clientSelect" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Select client...</option>
                    <?php foreach ($clients as $c): ?>
                    <option value="<?= $c['_id'] ?>" data-name="<?= htmlspecialchars($c['name']) ?>"
                            <?= ($quote['client_id'] ?? '') == $c['_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="client_name" id="clientName" value="<?= htmlspecialchars($quote['client_name'] ?? '') ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Total Amount (€) *</label>
                <input type="number" name="amount" id="amountInput" step="0.01" min="0" required
                       value="<?= $quote['amount'] ?? '' ?>" oninput="calcR()"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Advanced Payment (€)</label>
                <input type="number" name="advanced_payment" id="advInput" step="0.01" min="0"
                       value="<?= $quote['advanced_payment'] ?? 0 ?>" oninput="calcR()"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div class="bg-slate-50 rounded-xl px-4 py-3 flex justify-between">
                <span class="text-sm font-medium text-slate-600">Remaining</span>
                <span id="remDisplay" class="text-sm font-bold text-blue-600">€ 0,00</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                <input type="text" name="description" value="<?= htmlspecialchars($quote['description'] ?? '') ?>"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <?php if (!empty($services)): ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Services Included</label>
                <div class="space-y-2 border border-slate-200 rounded-xl p-3">
                    <?php $sel = array_map('strval', (array)($quote['services'] ?? []));
                    foreach ($services as $sv): ?>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="services[]" value="<?= $sv['_id'] ?>"
                               <?= in_array((string)$sv['_id'], $sel) ? 'checked' : '' ?>
                               class="w-4 h-4 rounded text-blue-600">
                        <span class="text-sm text-slate-700 flex-1"><?= htmlspecialchars($sv['name']) ?></span>
                        <span class="text-xs font-semibold text-slate-500"><?= number_format($sv['price'] ?? 0, 2, ',', '.') ?> €</span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Valid Until</label>
                <input type="date" name="valid_until" value="<?= htmlspecialchars($quote['valid_until'] ?? '') ?>"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes for Client</label>
                <textarea name="notes" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition resize-none"><?= htmlspecialchars($quote['notes'] ?? '') ?></textarea>
            </div>

            <?php if ($quote): ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Quote Status</label>
                <select name="quote_status" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <?php foreach (['draft','sent','approved','rejected'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($quote['quote_status'] ?? 'draft') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl transition text-sm">
                    <?= $quote ? 'Update Quote' : 'Create Quote' ?>
                </button>
                <a href="index.php?page=quotes" class="flex-1 text-center border border-slate-200 text-slate-600 font-medium py-2.5 rounded-xl hover:bg-slate-50 transition text-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('clientSelect').addEventListener('change', function() {
    document.getElementById('clientName').value = this.options[this.selectedIndex].dataset.name || '';
});
function calcR() {
    const t = parseFloat(document.getElementById('amountInput').value) || 0;
    const a = parseFloat(document.getElementById('advInput').value) || 0;
    document.getElementById('remDisplay').textContent = '€ ' + (t - a).toFixed(2).replace('.', ',');
}
calcR();
</script>
