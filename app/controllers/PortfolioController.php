<?php
require_once __DIR__ . '/Controller.php';

class PortfolioController extends Controller {

    private function collection() {
        return Database::getInstance()->getCollection('portfolio_categories');
    }

    private function imagesCollection() {
        return Database::getInstance()->getCollection('portfolio_images');
    }

    public function index(): void {
        $categories = $this->collection()->find([], ['sort' => ['created_at' => -1]])->toArray();
        $this->render('portfolio/index', compact('categories'));
    }

    public function create(): void {
        $this->render('portfolio/form', ['category' => null, 'action' => 'store', 'error' => null]);
    }

    public function store(): void {
        $name = trim($_POST['name'] ?? '');

        if (!$name) {
            $this->render('portfolio/form', ['category' => null, 'action' => 'store', 'error' => 'Category name is required.']);
            return;
        }

        $exists = $this->collection()->findOne(['name' => $name]);
        if ($exists) {
            $this->render('portfolio/form', ['category' => null, 'action' => 'store', 'error' => 'Category with this name already exists.']);
            return;
        }

        $this->collection()->insertOne([
            'name' => $name,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);

        header('Location: index.php?page=portfolio&success=created');
        exit;
    }

    public function edit(): void {
        $category = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($_GET['id'])]);
        $this->render('portfolio/form', ['category' => $category, 'action' => 'update', 'error' => null]);
    }

    public function update(): void {
        $id = $_POST['id'] ?? '';
        $name = trim($_POST['name'] ?? '');

        if (!$id || !$name) {
            $category = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            $this->render('portfolio/form', ['category' => $category, 'action' => 'update', 'error' => 'Category name is required.']);
            return;
        }

        $this->collection()->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['name' => $name]]
        );

        header('Location: index.php?page=portfolio&success=updated');
        exit;
    }

    public function delete(): void {
        $id = $_GET['id'] ?? '';
        if ($id) {
            $this->collection()->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            $this->imagesCollection()->deleteMany(['category_id' => $id]);
        }
        header('Location: index.php?page=portfolio&success=deleted');
        exit;
    }

    public function images(): void {
        $categoryId = $_GET['id'] ?? '';
        $category = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($categoryId)]);
        $images = $this->imagesCollection()->find(['category_id' => $categoryId], ['sort' => ['created_at' => -1]])->toArray();
        $this->render('portfolio/images', compact('category', 'images'));
    }

    public function addImage(): void {
        $categoryId = $_POST['category_id'] ?? '';
        $cloudinaryUrl = trim($_POST['cloudinary_url'] ?? '');

        if (!$categoryId || !$cloudinaryUrl) {
            header('Location: index.php?page=portfolio&action=images&id=' . $categoryId . '&error=missing');
            exit;
        }

        $this->imagesCollection()->insertOne([
            'category_id' => $categoryId,
            'cloudinary_url' => $cloudinaryUrl,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);

        header('Location: index.php?page=portfolio&action=images&id=' . $categoryId . '&success=added');
        exit;
    }

    public function deleteImage(): void {
        $imageId = $_GET['image_id'] ?? '';
        $categoryId = $_GET['category_id'] ?? '';
        
        if ($imageId) {
            $this->imagesCollection()->deleteOne(['_id' => new MongoDB\BSON\ObjectId($imageId)]);
        }
        
        header('Location: index.php?page=portfolio&action=images&id=' . $categoryId . '&success=deleted');
        exit;
    }

    public function api(): void {
        header('Content-Type: application/json');
        
        $categories = $this->collection()->find([], ['sort' => ['created_at' => -1]])->toArray();
        $result = [];

        foreach ($categories as $category) {
            $images = $this->imagesCollection()->find(
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
        exit;
    }
}
