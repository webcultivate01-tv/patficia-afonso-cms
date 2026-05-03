<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Payment.php';

class StatementController extends Controller {
    public function index(): void {
        $clients = (new Client())->all();
        $this->render('statement/index', compact('clients'));
    }

    public function view(): void {
        $clientId = $_GET['client_id'] ?? '';
        if (!$clientId) { header('Location: index.php?page=statement'); exit; }

        $client   = (new Client())->find($clientId);
        if (!$client) { header('Location: index.php?page=statement'); exit; }

        $db       = Database::getInstance();
        $payments = $db->getCollection('payments')->find(
            ['client_id' => $clientId, 'type' => ['$ne' => 'quote']],
            ['sort' => ['created_at' => 1]]
        )->toArray();

        $totalBilled    = array_sum(array_map(fn($p) => (float)($p['amount'] ?? 0), $payments));
        $totalCollected = array_sum(array_map(fn($p) => ($p['status'] ?? '') === 'paid' ? (float)($p['amount'] ?? 0) : 0, $payments));
        $balance        = $totalBilled - $totalCollected;

        require __DIR__ . '/../views/statement/print.php';
    }
}
