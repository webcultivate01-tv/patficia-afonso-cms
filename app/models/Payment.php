<?php
require_once __DIR__ . '/Model.php';
class Payment extends Model {
    protected string $collection = 'payments';

    public function col() {
        return parent::col();
    }
}
