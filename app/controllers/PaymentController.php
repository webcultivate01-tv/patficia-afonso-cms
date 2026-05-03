<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Service.php';

class PaymentController extends Controller {
    private Payment $model;

    public function __construct() {
        $this->model = new Payment();
    }

    public function index(): void {
        $payments = $this->model->all();
        $this->render('payments/index', compact('payments'));
    }

    public function create(): void {
        $clients  = (new Client())->all();
        $services = (new Service())->all();
        $this->render('payments/form', ['payment' => null, 'clients' => $clients, 'services' => $services, 'action' => 'store']);
    }

    private function nextInvoiceId(): string {
        $last = $this->model->col()->findOne([], ['sort' => ['invoice_id' => -1], 'projection' => ['invoice_id' => 1]]);
        if ($last && !empty($last['invoice_id'])) {
            return (string)((int)$last['invoice_id'] + 1);
        }
        return '202601';
    }

    public function getNextInvoiceId(): string {
        return $this->nextInvoiceId();
    }

    public function store(): void {
        $total    = (float) $_POST['amount'];
        $advanced = (float) ($_POST['advanced_payment'] ?? 0);
        // grab client phone for chase button
        $clientPhone = '';
        try {
            $c = (new Client())->find($_POST['client_id']);
            $clientPhone = $c['phone'] ?? '';
        } catch (\Exception $e) {}
        $this->model->create([
            'invoice_id'       => $this->nextInvoiceId(),
            'client_id'        => $_POST['client_id'],
            'client_name'      => $_POST['client_name'],
            'client_phone'     => $clientPhone,
            'amount'           => $total,
            'advanced_payment' => $advanced,
            'remaining'        => $total - $advanced,
            'description'      => $_POST['description'] ?? '',
            'services'         => $_POST['services'] ?? [],
            'status'           => $_POST['status'],
            'due_date'         => $_POST['due_date'],
            'paid_at'          => $_POST['status'] === 'paid' ? date('Y-m-d H:i:s') : null,
            'created_at'       => new MongoDB\BSON\UTCDateTime(),
        ]);
        header('Location: index.php?page=payments');
    }

    public function edit(): void {
        $payment  = $this->model->find($_GET['id']);
        $clients  = (new Client())->all();
        $services = (new Service())->all();
        $this->render('payments/form', ['payment' => $payment, 'clients' => $clients, 'services' => $services, 'action' => 'update']);
    }

    public function update(): void {
        $total    = (float) $_POST['amount'];
        $advanced = (float) ($_POST['advanced_payment'] ?? 0);
        $existing = $this->model->find($_POST['id']);
        $paidAt   = ($existing['paid_at'] ?? null);
        if ($_POST['status'] === 'paid' && !$paidAt) $paidAt = date('Y-m-d H:i:s');
        $this->model->update($_POST['id'], [
            'client_id'        => $_POST['client_id'],
            'client_name'      => $_POST['client_name'],
            'amount'           => $total,
            'advanced_payment' => $advanced,
            'remaining'        => $total - $advanced,
            'description'      => $_POST['description'] ?? '',
            'services'         => $_POST['services'] ?? [],
            'status'           => $_POST['status'],
            'due_date'         => $_POST['due_date'],
            'paid_at'          => $paidAt,
        ]);
        header('Location: index.php?page=payments');
    }

    public function delete(): void {
        $this->model->delete($_GET['id']);
        header('Location: index.php?page=payments');
    }

    public function invoice(): void {
        $payment = $this->model->find($_GET['id']);
        if (!$payment) { header('Location: index.php?page=payments'); exit; }
        // Fetch full client record
        $client = null;
        if (!empty($payment['client_id'])) {
            try { $client = (new Client())->find((string)$payment['client_id']); } catch (\Exception $e) {}
        }
        // Fetch linked project
        require_once __DIR__ . '/../models/Project.php';
        $project = null;
        try {
            $projects = (new Project())->all();
            foreach ($projects as $p) {
                if ((string)($p['client_id'] ?? '') === (string)($payment['client_id'] ?? '')) {
                    $project = $p; break;
                }
            }
        } catch (\Exception $e) {}
        // Fetch services
        require_once __DIR__ . '/../models/Service.php';
        $allServices = [];
        try { $allServices = (new Service())->all(); } catch (\Exception $e) {}
        $serviceIds = array_map('strval', (array)($payment['services'] ?? []));
        $billServices = array_filter($allServices, fn($s) => in_array((string)$s['_id'], $serviceIds));
        require __DIR__ . '/../views/payments/invoice.php';
    }
}
