<?php
require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$categoriesCollection = Database::getInstance()->getCollection('portfolio_categories');
$imagesCollection = Database::getInstance()->getCollection('portfolio_images');

$categories = $categoriesCollection->find([], ['sort' => ['created_at' => -1]])->toArray();
$result = [];

foreach ($categories as $category) {
    $images = $imagesCollection->find(
        ['category_id' => (string)$category['_id']], 
        ['sort' => ['created_at' => -1]]
    )->toArray();

    $result[] = [
        'id' => (string)$category['_id'],
        'name' => $category['name'],
        'images' => array_map(function($img) {
            return [
                'id' => (string)$img['_id'],
                'url' => $img['cloudinary_url']
            ];
        }, iterator_to_array($images))
    ];
}

echo json_encode($result);
