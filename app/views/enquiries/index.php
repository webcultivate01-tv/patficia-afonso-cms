<?php
$success = $_GET['success'] ?? null;
?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Enquiries</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage contact form submissions</p>
    </div>
</div>

<?php if ($success === 'deleted'): ?>
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Enquiry deleted successfully.
</div>
<?php endif; ?>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Total Enquiries</p>
        <p class="text-3xl font-bold text-slate-800"><?= count($enquiries) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Unread</p>
        <p class="text-3xl font-bold text-orange-600"><?= count(array_filter($enquiries, fn($e) => !($e['read'] ?? false))) ?></p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 mb-1">Read</p>
        <p class="text-3xl font-bold text-green-600"><?= count(array_filter($enquiries, fn($e) => ($e['read'] ?? false))) ?></p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">All Enquiries</h3>
        <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full"><?= count($enquiries) ?> total</span>
    </div>

    <?php if (empty($enquiries)): ?>
    <div class="text-center py-16 text-gray-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <p class="text-sm">No enquiries yet</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-left font-semibold">Service</th>
                    <th class="px-6 py-3 text-left font-semibold">Date</th>
                    <th class="px-6 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($enquiries as $enq):
                    $isRead = $enq['read'] ?? false;
                    $createdAt = $enq['created_at'] instanceof MongoDB\BSON\UTCDateTime
                        ? $enq['created_at']->toDateTime()->format('M j, Y H:i')
                        : '—';
                    $fullName = ($enq['first_name'] ?? '') . ' ' . ($enq['last_name'] ?? '');
                ?>
                <tr class="hover:bg-gray-50/60 transition <?= !$isRead ? 'bg-blue-50/30' : '' ?>">
                    <td class="px-6 py-4">
                        <?php if (!$isRead): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                            <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                            New
                        </span>
                        <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600">
                            Read
                        </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($fullName) ?></p>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($enq['email'] ?? '') ?></td>
                    <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($enq['service'] ?? '') ?></td>
                    <td class="px-6 py-4 text-gray-400"><?= $createdAt ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="index.php?page=enquiries&action=view&id=<?= $enq['_id'] ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </a>
                            <a href="index.php?page=enquiries&action=delete&id=<?= $enq['_id'] ?>" onclick="return confirm('Delete this enquiry?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
