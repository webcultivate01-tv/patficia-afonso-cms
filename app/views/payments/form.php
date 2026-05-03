<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            <?= $payment ? 'Edit Payment' : 'New Payment' ?>
        </h2>

        <form method="POST" action="index.php?page=payments&action=<?= $action ?>" class="space-y-5">
            <?php if ($payment): ?>
                <input type="hidden" name="id" value="<?= $payment['_id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Client *</label>
                <select name="client_id" id="clientSelect" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="">Select client...</option>
                    <?php foreach ($clients as $c): ?>
                    <option value="<?= $c['_id'] ?>"
                            data-name="<?= htmlspecialchars($c['name']) ?>"
                            <?= ($payment['client_id'] ?? '') == $c['_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="client_name" id="clientName" value="<?= htmlspecialchars($payment['client_name'] ?? '') ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Project Cost (€) *</label>
                <input type="number" name="amount" id="amountInput" step="0.01" min="0" required
                       value="<?= $payment['amount'] ?? '' ?>"
                       oninput="calcRemaining()"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Advanced Payment (€)</label>
                <input type="number" name="advanced_payment" id="advancedInput" step="0.01" min="0"
                       value="<?= $payment['advanced_payment'] ?? 0 ?>"
                       oninput="calcRemaining()"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div class="bg-slate-50 rounded-xl px-4 py-3 flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600">Remaining Payment</span>
                <span id="remainingDisplay" class="text-sm font-bold text-blue-600">€ 0.00</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <input type="text" name="description"
                       value="<?= htmlspecialchars($payment['description'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <?php if (!empty($services)): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Services Included</label>
                <div class="space-y-2 border border-gray-200 rounded-xl p-3">
                    <?php
                    $selectedServices = array_map('strval', (array)($payment['services'] ?? []));
                    foreach ($services as $sv):
                    ?>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="services[]" value="<?= $sv['_id'] ?>"
                               <?= in_array((string)$sv['_id'], $selectedServices) ? 'checked' : '' ?>
                               class="w-4 h-4 rounded text-blue-600">
                        <span class="text-sm text-gray-700 flex-1"><?= htmlspecialchars($sv['name']) ?></span>
                        <span class="text-xs font-semibold text-gray-500"><?= number_format($sv['price'] ?? 0, 2, ',', '.') ?> €</span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Due Date</label>
                <input type="date" name="due_date"
                       value="<?= htmlspecialchars($payment['due_date'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status *</label>
                <select name="status" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <?php foreach (['pending','paid','overdue'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($payment['status'] ?? 'pending') === $s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl transition text-sm">
                    <?= $payment ? 'Update Payment' : 'Save Payment' ?>
                </button>
                <a href="index.php?page=payments"
                   class="flex-1 text-center border border-gray-200 text-gray-600 font-medium py-2.5 rounded-xl hover:bg-gray-50 transition text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('clientSelect').addEventListener('change', function() {
    document.getElementById('clientName').value = this.options[this.selectedIndex].dataset.name || '';
});
function calcRemaining() {
    const total    = parseFloat(document.getElementById('amountInput').value) || 0;
    const advanced = parseFloat(document.getElementById('advancedInput').value) || 0;
    document.getElementById('remainingDisplay').textContent = '€ ' + (total - advanced).toFixed(2).replace('.', ',');
}
calcRemaining();
</script>
