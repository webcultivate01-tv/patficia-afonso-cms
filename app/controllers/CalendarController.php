<?php
require_once __DIR__ . '/Controller.php';

class CalendarController extends Controller {
    public function index(): void {
        $db       = Database::getInstance();
        $projects = $db->getCollection('projects')->find([], ['projection' => ['title'=>1,'deadline'=>1,'status'=>1,'client_name'=>1]])->toArray();
        $payments = $db->getCollection('payments')->find(['type' => ['$ne' => 'quote']], ['projection' => ['client_name'=>1,'due_date'=>1,'status'=>1,'amount'=>1,'invoice_id'=>1]])->toArray();

        // Build events array for JS
        $events = [];
        foreach ($projects as $p) {
            if (empty($p['deadline'])) continue;
            $events[] = [
                'title'  => '📁 ' . ($p['title'] ?? 'Project'),
                'date'   => $p['deadline'],
                'type'   => 'project',
                'status' => $p['status'] ?? 'active',
                'sub'    => $p['client_name'] ?? '',
            ];
        }
        foreach ($payments as $p) {
            if (empty($p['due_date'])) continue;
            $events[] = [
                'title'  => '💳 ' . ($p['client_name'] ?? 'Payment'),
                'date'   => $p['due_date'],
                'type'   => 'payment',
                'status' => $p['status'] ?? 'pending',
                'sub'    => number_format($p['amount'] ?? 0, 2, ',', '.') . ' €  · #' . ($p['invoice_id'] ?? ''),
            ];
        }

        $this->render('calendar/index', compact('events'));
    }
}
