<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            <?= $client ? 'Edit Client' : 'Add New Client' ?>
        </h2>

        <form method="POST" action="index.php?page=clients&action=<?= $action ?>" class="space-y-5">
            <?php if ($client): ?>
                <input type="hidden" name="id" value="<?= $client['_id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name *</label>
                <input type="text" name="name" required
                       value="<?= htmlspecialchars($client['name'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email *</label>
                <input type="email" name="email" required
                       value="<?= htmlspecialchars($client['email'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                <input type="text" name="phone"
                       value="<?= htmlspecialchars($client['phone'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company</label>
                <input type="text" name="company"
                       value="<?= htmlspecialchars($client['company'] ?? '') ?>"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-brand-600 to-purple-600 text-white font-medium py-2.5 rounded-xl hover:opacity-90 transition shadow text-sm">
                    <?= $client ? 'Update Client' : 'Add Client' ?>
                </button>
                <a href="index.php?page=clients"
                   class="flex-1 text-center border border-gray-200 text-gray-600 font-medium py-2.5 rounded-xl hover:bg-gray-50 transition text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
