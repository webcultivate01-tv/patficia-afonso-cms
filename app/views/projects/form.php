<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            <?= $project ? 'Edit Project' : 'New Project' ?>
        </h2>

        <form method="POST" action="index.php?page=projects&action=<?= $action ?>" class="space-y-5">
            <?php if ($project): ?>
                <input type="hidden" name="id" value="<?= $project['_id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Project Title *</label>
                <input type="text" name="title" required
                       value="<?= htmlspecialchars($project['title'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Client *</label>
                <select name="client_id" id="clientSelect" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition">
                    <option value="">Select client...</option>
                    <?php foreach ($clients as $c): ?>
                    <option value="<?= $c['_id'] ?>"
                            data-name="<?= htmlspecialchars($c['name']) ?>"
                            <?= ($project['client_id'] ?? '') == $c['_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="client_name" id="clientName" value="<?= htmlspecialchars($project['client_name'] ?? '') ?>">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition resize-none"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Budget ($)</label>
                    <input type="number" name="budget" step="0.01" min="0"
                           value="<?= $project['budget'] ?? '' ?>"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deadline</label>
                    <input type="date" name="deadline"
                           value="<?= htmlspecialchars($project['deadline'] ?? '') ?>"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status *</label>
                <select name="status" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 transition">
                    <?php foreach (['active','completed','on-hold','cancelled'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($project['status'] ?? 'active') === $s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl transition text-sm">
                    <?= $project ? 'Update Project' : 'Save Project' ?>
                </button>
                <a href="index.php?page=projects"
                   class="flex-1 text-center border border-gray-200 text-gray-600 font-medium py-2.5 rounded-xl hover:bg-gray-50 transition text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('clientSelect').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    document.getElementById('clientName').value = opt.dataset.name || '';
});
</script>
