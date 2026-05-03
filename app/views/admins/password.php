<div class="max-w-lg mx-auto">

    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="index.php?page=admins" class="hover:text-blue-600 transition">Admin Management</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-700 font-medium">Change Password</span>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">

        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center text-white flex-shrink-0" style="background:#2563eb">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-slate-800 text-sm">Change Password</h2>
                    <p class="text-xs text-slate-400">
                        For: <span class="font-semibold text-slate-600"><?= htmlspecialchars($admin['name'] ?? '') ?></span>
                        · <?= htmlspecialchars($admin['email'] ?? '') ?>
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="index.php?page=admins&action=password" class="p-6 space-y-5">
            <input type="hidden" name="id" value="<?= $admin['_id'] ?>"/>

            <?php if (!empty($error)): ?>
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 rounded-lg px-4 py-3 text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">New Password</label>
                <input type="password" name="password" required minlength="6"
                       placeholder="Min. 6 characters"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"/>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Confirm Password</label>
                <input type="password" name="password_confirm" required minlength="6"
                       placeholder="Repeat new password"
                       class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"/>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition hover:bg-blue-700"
                        style="background:#2563eb">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Password
                </button>
                <a href="index.php?page=admins"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
