<?php
$success = $_GET['success'] ?? null;
$successMessages = [
    'created'  => 'Admin created successfully.',
    'updated'  => 'Admin updated successfully.',
    'deleted'  => 'Admin removed successfully.',
    'password' => 'Password changed successfully.',
];
?>

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Admin Management</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage all admin accounts and permissions</p>
    </div>
    <a href="index.php?page=admins&action=create"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition hover:bg-blue-700"
       style="background:#2563eb">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Admin
    </a>
</div>

<?php if ($success && isset($successMessages[$success])): ?>
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <?= $successMessages[$success] ?>
</div>
<?php endif; ?>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Total Admins</p>
        <p class="text-3xl font-bold text-slate-800"><?= count($admins) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Super Admins</p>
        <p class="text-3xl font-bold text-slate-800"><?= count(array_filter($admins, fn($a) => ($a['role'] ?? '') === 'superadmin')) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Regular Admins</p>
        <p class="text-3xl font-bold text-slate-800"><?= count(array_filter($admins, fn($a) => ($a['role'] ?? '') === 'admin')) ?></p>
    </div>
</div>

<!-- Admins Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">All Admins</h3>
        <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full"><?= count($admins) ?> total</span>
    </div>

    <?php if (empty($admins)): ?>
    <div class="text-center py-16 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="text-sm">No admins found</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left font-semibold">Admin</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-left font-semibold">Role</th>
                    <th class="px-6 py-3 text-left font-semibold">Created</th>
                    <th class="px-6 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($admins as $a):
                    $isSelf    = ($_SESSION['admin_id'] ?? '') === (string) $a['_id'];
                    $role      = $a['role'] ?? 'admin';
                    $createdAt = $a['created_at'] instanceof MongoDB\BSON\UTCDateTime
                        ? $a['created_at']->toDateTime()->format('M j, Y')
                        : '—';
                ?>
                <tr class="hover:bg-gray-50/60 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                 style="background:#2563eb">
                                <?= strtoupper(substr($a['name'] ?? 'A', 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($a['name'] ?? '') ?></p>
                                <?php if ($isSelf): ?>
                                <span class="text-xs text-green-600 font-medium">● You</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($a['email'] ?? '') ?></td>
                    <td class="px-6 py-4">
                        <?php
                            $roleColor = $role === 'superadmin'
                                ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                : 'bg-slate-100 text-slate-600 border border-slate-200';
                        ?>
                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold <?= $roleColor ?>">
                            <?= ucfirst($role) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400"><?= $createdAt ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <!-- Edit -->
                            <a href="index.php?page=admins&action=edit&id=<?= $a['_id'] ?>"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <!-- Change Password -->
                            <a href="index.php?page=admins&action=password&id=<?= $a['_id'] ?>"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                Password
                            </a>
                            <!-- Delete -->
                            <?php if (!$isSelf): ?>
                            <a href="index.php?page=admins&action=delete&id=<?= $a['_id'] ?>"
                               onclick="return confirm('Remove this admin?')"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Remove
                            </a>
                            <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-50 text-gray-300 cursor-not-allowed">
                                Remove
                            </span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
