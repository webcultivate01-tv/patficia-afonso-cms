<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/Client.php';

class ProjectController extends Controller {
    private Project $model;

    public function __construct() {
        $this->model = new Project();
    }

    public function index(): void {
        $projects = $this->model->all();
        $this->render('projects/index', compact('projects'));
    }

    public function create(): void {
        $clients = (new Client())->all();
        $this->render('projects/form', ['project' => null, 'clients' => $clients, 'action' => 'store']);
    }

    public function store(): void {
        $this->model->create([
            'title'       => $_POST['title'],
            'client_id'   => $_POST['client_id'],
            'client_name' => $_POST['client_name'],
            'description' => $_POST['description'] ?? '',
            'status'      => $_POST['status'],
            'budget'      => (float) $_POST['budget'],
            'deadline'    => $_POST['deadline'],
            'created_at'  => new MongoDB\BSON\UTCDateTime(),
        ]);
        header('Location: index.php?page=projects');
    }

    public function edit(): void {
        $project = $this->model->find($_GET['id']);
        $clients = (new Client())->all();
        $this->render('projects/form', ['project' => $project, 'clients' => $clients, 'action' => 'update']);
    }

    public function update(): void {
        $this->model->update($_POST['id'], [
            'title'       => $_POST['title'],
            'client_id'   => $_POST['client_id'],
            'client_name' => $_POST['client_name'],
            'description' => $_POST['description'] ?? '',
            'status'      => $_POST['status'],
            'budget'      => (float) $_POST['budget'],
            'deadline'    => $_POST['deadline'],
        ]);
        header('Location: index.php?page=projects');
    }

    public function delete(): void {
        $this->model->delete($_GET['id']);
        header('Location: index.php?page=projects');
    }
}
