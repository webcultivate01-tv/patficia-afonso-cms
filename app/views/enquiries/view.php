<?php
if (!$enquiry) {
    echo '<div class="text-center py-16"><p class="text-gray-400">Enquiry not found</p></div>';
    return;
}

$fullName = ($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? '');
$createdAt = $enquiry['created_at'] instanceof MongoDB\BSON\UTCDateTime
    ? $enquiry['created_at']->toDateTime()->format('l, F j, Y \a\t g:i A')
    : '—';
?>

<div class="max-w-4xl">
    <div class="mb-6">
        <a href="index.php?page=enquiries" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Enquiries
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($fullName) ?></h2>
                <p class="text-sm text-gray-400 mt-1"><?= $createdAt ?></p>
            </div>
            <?php if (!($enquiry['read'] ?? false)): ?>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                New
            </span>
            <?php else: ?>
            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                ✓ Read
            </span>
            <?php endif; ?>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Email</label>
                    <a href="mailto:<?= htmlspecialchars($enquiry['email'] ?? '') ?>" class="text-blue-600 hover:underline font-medium">
                        <?= htmlspecialchars($enquiry['email'] ?? '') ?>
                    </a>
                </div>
                <?php if (!empty($enquiry['phone'])): ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Phone</label>
                    <a href="tel:<?= htmlspecialchars($enquiry['phone']) ?>" class="text-blue-600 hover:underline font-medium">
                        <?= htmlspecialchars($enquiry['phone']) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Service Needed</label>
                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($enquiry['service'] ?? '—') ?></p>
                </div>
                <?php if (!empty($enquiry['budget'])): ?>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Budget Range</label>
                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($enquiry['budget']) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Project Details</label>
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($enquiry['message'] ?? '') ?></p>
                </div>
            </div>
        </div>

        <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <a href="mailto:<?= htmlspecialchars($enquiry['email'] ?? '') ?>" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Reply via Email
            </a>
            <a href="index.php?page=enquiries&action=delete&id=<?= $enquiry['_id'] ?>" onclick="return confirm('Delete this enquiry?')" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-50 text-red-600 hover:bg-red-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </a>
        </div>
    </div>
</div>
