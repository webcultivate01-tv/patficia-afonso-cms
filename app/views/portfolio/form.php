<?php
$isEdit = $category !== null;
$title  = $isEdit ? 'Edit Category' : 'Add Category';
?>

<div class="max-w-2xl">
    <div class="mb-6">
        <a href="index.php?page=portfolio" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6"><?= $title ?></h2>

        <?php if ($error): ?>
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=portfolio&action=<?= $action ?>" class="space-y-5">
            <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $category['_id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Category Name *</label>
                <input type="text" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                       placeholder="e.g., Branding, Motion Graphics, Web Design">
                <p class="text-xs text-gray-400 mt-1">This will appear on the website</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <?= $isEdit ? 'Update' : 'Create' ?> Category
                </button>
                <a href="index.php?page=portfolio" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
