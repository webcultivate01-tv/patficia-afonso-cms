<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Service.php';

class QuotesController extends Controller {
    private Payment $model;

    public function __construct() {
        $this->model = new Payment();
    }

    public function index(): void {
        $quotes = $this->model->col()->find(['type' => 'quote'], ['sort' => ['created_at' => -1]])->toArray();
        $this->render('quotes/index', compact('quotes'));
    }

    public function create(): void {
        $clients  = (new Client())->all();
        $services = (new Service())->all();
        $this->render('quotes/form', ['quote' => null, 'clients' => $clients, 'services' => $services, 'action' => 'store']);
    }

    public function store(): void {
        $total    = (float)$_POST['amount'];
        $advanced = (float)($_POST['advanced_payment'] ?? 0);
        $clientPhone = '';
        try { $c = (new Client())->find($_POST['client_id']); $clientPhone = $c['phone'] ?? ''; } catch (\Exception $e) {}
        $this->model->create([
            'type'             => 'quote',
            'quote_status'     => 'draft',
            'client_id'        => $_POST['client_id'],
            'client_name'      => $_POST['client_name'],
            'client_phone'     => $clientPhone,
            'amount'           => $total,
            'advanced_payment' => $advanced,
            'remaining'        => $total - $advanced,
            'description'      => $_POST['description'] ?? '',
            'services'         => $_POST['services'] ?? [],
            'valid_until'      => $_POST['valid_until'] ?? '',
            'notes'            => $_POST['notes'] ?? '',
            'status'           => 'pending',
            'due_date'         => $_POST['valid_until'] ?? '',
            'created_at'       => new MongoDB\BSON\UTCDateTime(),
        ]);
        header('Location: index.php?page=quotes');
    }

    public function edit(): void {
        $quote    = $this->model->find($_GET['id']);
        $clients  = (new Client())->all();
        $services = (new Service())->all();
        $this->render('quotes/form', ['quote' => $quote, 'clients' => $clients, 'services' => $services, 'action' => 'update']);
    }

    public function update(): void {
        $total    = (float)$_POST['amount'];
        $advanced = (float)($_POST['advanced_payment'] ?? 0);
        $this->model->update($_POST['id'], [
            'client_id'        => $_POST['client_id'],
            'client_name'      => $_POST['client_name'],
            'amount'           => $total,
            'advanced_payment' => $advanced,
            'remaining'        => $total - $advanced,
            'description'      => $_POST['description'] ?? '',
            'services'         => $_POST['services'] ?? [],
            'valid_until'      => $_POST['valid_until'] ?? '',
            'notes'            => $_POST['notes'] ?? '',
            'due_date'         => $_POST['valid_until'] ?? '',
            'quote_status'     => $_POST['quote_status'] ?? 'draft',
        ]);
        header('Location: index.php?page=quotes');
    }

    public function approve(): void {
        // Convert quote → payment
        $quote = $this->model->find($_GET['id']);
        if ($quote) {
            // Get next invoice id
            require_once __DIR__ . '/PaymentController.php';
            $pc = new PaymentController();
            $invoiceId = $pc->getNextInvoiceId();
            $this->model->update($_GET['id'], [
                'type'         => 'payment',
                'quote_status' => 'approved',
                'invoice_id'   => $invoiceId,
                'status'       => 'pending',
            ]);
        }
        header('Location: index.php?page=quotes');
    }

    public function delete(): void {
        $this->model->delete($_GET['id']);
        header('Location: index.php?page=quotes');
    }

    public function preview(): void {
        $quote = $this->model->find($_GET['id']);
        if (!$quote) { header('Location: index.php?page=quotes'); exit; }
        $client = null;
        try { $client = (new Client())->find((string)$quote['client_id']); } catch (\Exception $e) {}
        $allServices = (new Service())->all();
        $serviceIds  = array_map('strval', (array)($quote['services'] ?? []));
        $billServices = array_filter($allServices, fn($s) => in_array((string)$s['_id'], $serviceIds));
        require __DIR__ . '/../views/quotes/preview.php';
    }
}
