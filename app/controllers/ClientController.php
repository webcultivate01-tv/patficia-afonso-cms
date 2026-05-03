<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Client.php';

class ClientController extends Controller {
    private Client $model;

    public function __construct() {
        $this->model = new Client();
    }

    public function index(): void {
        $clients = $this->model->all();
        $this->render('clients/index', compact('clients'));
    }

    public function create(): void {
        $this->render('clients/form', ['client' => null, 'action' => 'store']);
    }

    public function store(): void {
        $this->model->create([
            'name'       => $_POST['name'],
            'email'      => $_POST['email'],
            'phone'      => $_POST['phone'],
            'company'    => $_POST['company'] ?? '',
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);
        header('Location: index.php?page=clients');
    }

    public function edit(): void {
        $client = $this->model->find($_GET['id']);
        $this->render('clients/form', ['client' => $client, 'action' => 'update']);
    }

    public function update(): void {
        $this->model->update($_POST['id'], [
            'name'    => $_POST['name'],
            'email'   => $_POST['email'],
            'phone'   => $_POST['phone'],
            'company' => $_POST['company'] ?? '',
        ]);
        header('Location: index.php?page=clients');
    }

    public function delete(): void {
        $this->model->delete($_GET['id']);
        header('Location: index.php?page=clients');
    }

    public function view(): void {
        $client = $this->model->find($_GET['id']);
        if (!$client) { header('Location: index.php?page=clients'); exit; }
        $db       = Database::getInstance();
        $clientId = (string)$client['_id'];
        $projects = $db->getCollection('projects')->find(['client_id' => $clientId], ['sort' => ['created_at' => -1]])->toArray();
        $payments = $db->getCollection('payments')->find(['client_id' => $clientId], ['sort' => ['created_at' => -1]])->toArray();
        $totalBilled    = array_sum(array_map(fn($p) => (float)($p['amount'] ?? 0), $payments));
        $totalCollected = array_sum(array_map(fn($p) => ($p['status'] ?? '') === 'paid' ? (float)($p['amount'] ?? 0) : 0, $payments));
        $totalOwed      = array_sum(array_map(fn($p) => ($p['status'] ?? '') !== 'paid' ? (float)($p['remaining'] ?? $p['amount'] ?? 0) : 0, $payments));
        $this->render('clients/view', compact('client','projects','payments','totalBilled','totalCollected','totalOwed'));
    }
}
