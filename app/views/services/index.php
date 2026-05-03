<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Services</h2>
        <a href="index.php?page=services&action=create"
           class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-lg transition" style="background:#2563eb" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Service
        </a>
    </div>

    <?php if (empty($services)): ?>
        <div class="text-center py-16 text-gray-400 text-sm">No services added yet.</div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($services as $s): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($s['name'] ?? '') ?></td>
                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($s['description'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-bold text-gray-800"><?= number_format($s['price'] ?? 0, 2, ',', '.') ?> €</td>
                    <td class="px-6 py-4 text-right">
                        <a href="index.php?page=services&action=edit&id=<?= $s['_id'] ?>"
                           class="text-xs text-blue-600 hover:text-blue-800 font-medium mr-3">Edit</a>
                        <a href="index.php?page=services&action=delete&id=<?= $s['_id'] ?>"
                           onclick="return confirm('Delete this service?')"
                           class="text-xs text-red-500 hover:text-red-700 font-medium">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
