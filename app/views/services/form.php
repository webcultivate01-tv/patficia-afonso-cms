<div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <h2 class="font-semibold text-gray-800 mb-6"><?= $service ? 'Edit Service' : 'New Service' ?></h2>

    <form method="POST" action="index.php?page=services&action=<?= $action ?>" class="space-y-5">
        <?php if ($service): ?>
            <input type="hidden" name="id" value="<?= $service['_id'] ?>">
        <?php endif; ?>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Service Name</label>
            <input type="text" name="name" required
                   value="<?= htmlspecialchars($service['name'] ?? '') ?>"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Price (€)</label>
            <input type="number" name="price" step="0.01" min="0" required
                   value="<?= htmlspecialchars($service['price'] ?? '') ?>"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">
                <?= $service ? 'Update Service' : 'Add Service' ?>
            </button>
            <a href="index.php?page=services" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
