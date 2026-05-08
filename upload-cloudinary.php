<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'No image provided']);
    exit;
}

$file = $_FILES['image'];

// Cloudinary configuration
$cloudName = 'duw0fnlqe';
$apiKey = '426296837257421';
$apiSecret = 'dxzfhr8Dwo4FzeGrym3Ubtn2eT4';

// Validate file
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'File upload error']);
    exit;
}

// Prepare upload to Cloudinary
$uploadUrl = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

// Generate signature for authenticated upload
$timestamp = time();
$stringToSign = "timestamp={$timestamp}{$apiSecret}";
$signature = sha1($stringToSign);

$postData = [
    'file' => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
    'api_key' => $apiKey,
    'timestamp' => $timestamp,
    'signature' => $signature
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uploadUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $result = json_decode($response, true);
    echo json_encode([
        'success' => true,
        'url' => $result['secure_url']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Cloudinary upload failed',
        'details' => $response
    ]);
}
