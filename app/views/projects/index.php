<?php
function projBadge(string $s): string {
    $map = [
        'active'    => 'bg-blue-100 text-blue-700',
        'completed' => 'bg-green-100 text-green-700',
        'on-hold'   => 'bg-gray-100 text-gray-600',
        'cancelled' => 'bg-red-100 text-red-600',
    ];
    $cls = $map[strtolower($s)] ?? 'bg-gray-100 text-gray-600';
    return "<span class='inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {$cls}'>".ucfirst($s)."</span>";
}
?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">All Projects</h2>
        <a href="index.php?page=projects&action=create"
           class="inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-lg transition" style="background:#2563eb" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </a>
    </div>

    <?php if (empty($projects)): ?>
        <div class="text-center py-16 text-gray-400 text-sm">No projects yet.</div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">Project</th>
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Budget</th>
                    <th class="px-6 py-3 text-left">Deadline</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($projects as $p): ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800"><?= htmlspecialchars($p['title'] ?? '') ?></p>
                        <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs"><?= htmlspecialchars($p['description'] ?? '') ?></p>
                    </td>
                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($p['client_name'] ?? '—') ?></td>
                    <td class="px-6 py-4 font-bold text-gray-800"><?= number_format($p['budget'] ?? 0, 2, ',', '.') ?> €</td>
                    <td class="px-6 py-4 text-gray-500"><?= htmlspecialchars($p['deadline'] ?? '—') ?></td>
                    <td class="px-6 py-4"><?= projBadge($p['status'] ?? 'active') ?></td>
                    <td class="px-6 py-4 text-right">
                        <a href="index.php?page=projects&action=edit&id=<?= $p['_id'] ?>"
                           class="text-xs text-blue-600 hover:text-blue-800 font-medium mr-3">Edit</a>
                        <a href="index.php?page=projects&action=delete&id=<?= $p['_id'] ?>"
                           onclick="return confirm('Delete this project?')"
                           class="text-xs text-red-500 hover:text-red-700 font-medium">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
