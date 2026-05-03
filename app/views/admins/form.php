<?php
$isEdit = $admin !== null;
$title  = $isEdit ? 'Edit Admin' : 'Add New Admin';
?>

<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="index.php?page=admins" class="hover:text-blue-600 transition">Admin Management</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-700 font-medium"><?= $title ?></span>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">

        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white flex-shrink-0" style="background:#2563eb">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="<?= $isEdit ? 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' : 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z' ?>"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-slate-800 text-sm"><?= $title ?></h2>
                    <p class="text-xs text-slate-400"><?= $isEdit ? 'Update admin details' : 'Create a new admin account' ?></p>
                </div>
            </div>
        </div>

        <form method="POST" action="index.php?page=admins&action=<?= $action ?>" class="p-6 space-y-5">
            <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $admin['_id'] ?>"/>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 rounded-lg px-4 py-3 text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Full Name</label>
                <input type="text" name="name" required
                       value="<?= htmlspecialchars($admin['name'] ?? '') ?>"
                       placeholder="e.g. Patricia Afonso"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"/>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Email Address</label>
                <input type="email" name="email" required
                       value="<?= htmlspecialchars($admin['email'] ?? '') ?>"
                       placeholder="admin@patridesigns.com"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"/>
            </div>

            <?php if (!$isEdit): ?>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Password</label>
                <input type="password" name="password" required minlength="6"
                       placeholder="Min. 6 characters"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"/>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Role</label>
                <select name="role"
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white">
                    <option value="admin"      <?= ($admin['role'] ?? 'admin') === 'admin'      ? 'selected' : '' ?>>Admin</option>
                    <option value="superadmin" <?= ($admin['role'] ?? '')      === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                </select>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition hover:bg-blue-700"
                        style="background:#2563eb">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <?= $isEdit ? 'Save Changes' : 'Create Admin' ?>
                </button>
                <a href="index.php?page=admins"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
