<?php
require_once __DIR__ . '/Controller.php';

class AgingController extends Controller {
    public function index(): void {
        $db       = Database::getInstance();
        $payments = $db->getCollection('payments')->find([
            'type'   => ['$ne' => 'quote'],
            'status' => ['$in' => ['pending', 'overdue']],
        ], ['sort' => ['due_date' => 1]])->toArray();

        $today   = new DateTime();
        $buckets = ['current' => [], '1_30' => [], '31_60' => [], '61_90' => [], '90plus' => []];

        foreach ($payments as $p) {
            if (empty($p['due_date'])) { $buckets['current'][] = $p; continue; }
            try {
                $due  = new DateTime($p['due_date']);
                $days = (int)$today->diff($due)->days * ($due < $today ? 1 : -1);
            } catch (\Exception $e) { $buckets['current'][] = $p; continue; }

            if ($days <= 0)       $buckets['current'][] = $p;
            elseif ($days <= 30)  $buckets['1_30'][]    = $p;
            elseif ($days <= 60)  $buckets['31_60'][]   = $p;
            elseif ($days <= 90)  $buckets['61_90'][]   = $p;
            else                  $buckets['90plus'][]  = $p;
        }

        $totals = [];
        foreach ($buckets as $k => $items) {
            $totals[$k] = array_sum(array_map(fn($p) => (float)($p['remaining'] ?? $p['amount'] ?? 0), $items));
        }

        $grandTotal = array_sum($totals);
        $this->render('aging/index', compact('buckets', 'totals', 'grandTotal'));
    }
}
