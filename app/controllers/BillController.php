<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Payment.php';

class BillController extends Controller {
    private Payment $model;

    public function __construct() {
        $this->model = new Payment();
    }

    public function index(): void {
        $bills = $this->model->all();
        $this->render('bills/index', compact('bills'));
    }
}
