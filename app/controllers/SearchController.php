<?php
require_once __DIR__ . '/Controller.php';

class SearchController extends Controller {
    public function index(): void {
        $q       = trim($_GET['q'] ?? '');
        $clients  = [];
        $projects = [];
        $payments = [];

        if ($q !== '') {
            $db     = Database::getInstance();
            $regex  = new MongoDB\BSON\Regex($q, 'i');

            $clients = $db->getCollection('clients')->find([
                '$or' => [['name' => $regex], ['email' => $regex], ['company' => $regex], ['phone' => $regex]]
            ])->toArray();

            $projects = $db->getCollection('projects')->find([
                '$or' => [['title' => $regex], ['client_name' => $regex], ['description' => $regex]]
            ])->toArray();

            $payments = $db->getCollection('payments')->find([
                'type' => ['$ne' => 'quote'],
                '$or'  => [['client_name' => $regex], ['description' => $regex], ['invoice_id' => $regex]]
            ])->toArray();
        }

        $total = count($clients) + count($projects) + count($payments);
        $this->render('search/index', compact('q', 'clients', 'projects', 'payments', 'total'));
    }
}
