<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Service.php';

class ServiceController extends Controller {
    private Service $model;

    public function __construct() {
        $this->model = new Service();
    }

    public function index(): void {
        $services = $this->model->all();
        $this->render('services/index', compact('services'));
    }

    public function create(): void {
        $this->render('services/form', ['service' => null, 'action' => 'store']);
    }

    public function store(): void {
        $this->model->create([
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => (float) $_POST['price'],
            'created_at'  => new MongoDB\BSON\UTCDateTime(),
        ]);
        header('Location: index.php?page=services');
    }

    public function edit(): void {
        $service = $this->model->find($_GET['id']);
        $this->render('services/form', ['service' => $service, 'action' => 'update']);
    }

    public function update(): void {
        $this->model->update($_POST['id'], [
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => (float) $_POST['price'],
        ]);
        header('Location: index.php?page=services');
    }

    public function delete(): void {
        $this->model->delete($_GET['id']);
        header('Location: index.php?page=services');
    }
}
