<?php
$success = $_GET['success'] ?? null;
$error = $_GET['error'] ?? null;
?>

<div class="mb-6">
    <a href="index.php?page=portfolio" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Categories
    </a>
</div>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($category['name'] ?? 'Category') ?> Images</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage images for this portfolio category</p>
    </div>
    <button onclick="openUploadModal()" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Image
    </button>
</div>

<?php if ($success === 'added'): ?>
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Image added successfully.
</div>
<?php endif; ?>

<?php if ($success === 'deleted'): ?>
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Image deleted successfully.
</div>
<?php endif; ?>

<?php if ($error === 'missing'): ?>
<div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    All fields are required.
</div>
<?php endif; ?>

<?php if (empty($images)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
    <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <p class="text-gray-400 mb-4">No images yet</p>
    <button onclick="openUploadModal()" class="btn-primary">Add First Image</button>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($images as $img): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
        <div class="aspect-video bg-gray-100 overflow-hidden">
            <img src="<?= htmlspecialchars($img['cloudinary_url']) ?>" alt="Portfolio Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        </div>
        <div class="p-4">
            <a href="index.php?page=portfolio&action=deleteImage&image_id=<?= $img['_id'] ?>&category_id=<?= $category['_id'] ?>" 
               onclick="return confirm('Delete this image?')"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-600 hover:bg-red-100 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">Add New Image</h3>
            <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="index.php?page=portfolio&action=addImage" id="imageForm" class="space-y-5">
            <input type="hidden" name="category_id" value="<?= $category['_id'] ?>">
            <input type="hidden" name="cloudinary_url" id="cloudinaryUrl" required>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image *</label>
                <input type="file" id="imageUpload" accept="image/*" required class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-primary hover:file:bg-purple-100">
                <p class="text-xs text-gray-400 mt-2">Image will be uploaded to Cloudinary</p>
                <div id="uploadProgress" class="hidden mt-3">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="animate-spin h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading to Cloudinary...
                    </div>
                </div>
                <div id="uploadedPreview" class="hidden mt-3">
                    <img id="previewImage" src="" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                    <p class="text-xs text-green-600 mt-1">✓ Image uploaded successfully</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Add Image
                </button>
                <button type="button" onclick="closeUploadModal()" class="btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    document.getElementById('imageForm').reset();
    document.getElementById('uploadedPreview').classList.add('hidden');
    document.getElementById('uploadProgress').classList.add('hidden');
}

// Direct Cloudinary Upload via Backend (Signed)
document.getElementById('imageUpload').addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('image', file);

    document.getElementById('uploadProgress').classList.remove('hidden');
    document.getElementById('uploadedPreview').classList.add('hidden');

    try {
        const response = await fetch('upload-cloudinary.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        
        if (data.success && data.url) {
            document.getElementById('cloudinaryUrl').value = data.url;
            document.getElementById('previewImage').src = data.url;
            document.getElementById('uploadProgress').classList.add('hidden');
            document.getElementById('uploadedPreview').classList.remove('hidden');
        } else {
            throw new Error(data.error || 'Upload failed');
        }
    } catch (error) {
        document.getElementById('uploadProgress').classList.add('hidden');
        alert('Upload failed: ' + error.message);
        console.error('Upload error:', error);
    }
});
</script>
