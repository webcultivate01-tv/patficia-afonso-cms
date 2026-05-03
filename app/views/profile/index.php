<div class="max-w-lg mx-auto">

    <?php if ($success): ?>
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-2xl px-5 py-4 mb-5 text-sm font-semibold">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Profile updated successfully!
    </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 mb-5 text-sm font-semibold">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <!-- Avatar Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-5 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl font-black flex-shrink-0" style="background:#2563eb">
            <?= strtoupper(substr($admin['name'] ?? 'A', 0, 1)) ?>
        </div>
        <div>
            <p class="text-lg font-extrabold text-slate-900"><?= htmlspecialchars($admin['name'] ?? '') ?></p>
            <p class="text-sm text-slate-500"><?= htmlspecialchars($admin['email'] ?? '') ?></p>
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"><?= ucfirst($admin['role'] ?? 'admin') ?></span>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
        <h2 class="text-base font-bold text-slate-800 mb-6">Edit Profile</h2>

        <form method="POST" action="index.php?page=profile&action=update" class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name *</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($admin['name'] ?? '') ?>"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email *</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($admin['email'] ?? '') ?>"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <hr class="border-slate-100">
            <p class="text-xs text-slate-400 font-medium">Leave password fields blank to keep your current password</p>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                <input type="password" name="new_password" placeholder="Min. 6 characters"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm New Password</label>
                <input type="password" name="confirm_password"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
