<?php
require_once __DIR__ . '/Controller.php';

class ReportsController extends Controller {
    public function index(): void {
        $db       = Database::getInstance();
        $payments = $db->getCollection('payments')->find()->toArray();
        $projects = $db->getCollection('projects')->find()->toArray();

        // Monthly breakdown — all time
        $monthly = [];
        foreach ($payments as $p) {
            $ts = null;
            if (!empty($p['created_at'])) {
                try { $ts = intdiv((int)(string)$p['created_at'], 1000); } catch (\Exception $e) {}
            }
            $key   = $ts ? date('Y-m', $ts) : 'unknown';
            $label = $ts ? date('M Y', $ts)  : 'Unknown';
            if (!isset($monthly[$key])) $monthly[$key] = ['label' => $label, 'invoiced' => 0, 'collected' => 0, 'count' => 0];
            $monthly[$key]['invoiced']  += (float)($p['amount'] ?? 0);
            $monthly[$key]['collected'] += ($p['status'] ?? '') === 'paid' ? (float)($p['amount'] ?? 0) : 0;
            $monthly[$key]['count']++;
        }
        krsort($monthly); // newest first

        // Totals
        $totalInvoiced  = array_sum(array_column($monthly, 'invoiced'));
        $totalCollected = array_sum(array_column($monthly, 'collected'));
        $totalOutstanding = $totalInvoiced - $totalCollected;

        // Best month by collected
        $bestMonth = null;
        if ($monthly) {
            $bestKey   = array_keys($monthly)[0];
            foreach ($monthly as $k => $m) {
                if ($m['collected'] > ($monthly[$bestKey]['collected'] ?? 0)) $bestKey = $k;
            }
            $bestMonth = $monthly[$bestKey];
        }

        // Per-client totals
        $clientTotals = [];
        foreach ($payments as $p) {
            $name = $p['client_name'] ?? 'Unknown';
            if (!isset($clientTotals[$name])) $clientTotals[$name] = ['invoiced' => 0, 'collected' => 0, 'count' => 0];
            $clientTotals[$name]['invoiced']  += (float)($p['amount'] ?? 0);
            $clientTotals[$name]['collected'] += ($p['status'] ?? '') === 'paid' ? (float)($p['amount'] ?? 0) : 0;
            $clientTotals[$name]['count']++;
        }
        uasort($clientTotals, fn($a, $b) => $b['invoiced'] <=> $a['invoiced']);

        // Project stats
        $projectStats = ['active' => 0, 'completed' => 0, 'on-hold' => 0, 'cancelled' => 0];
        $totalBudget  = 0;
        foreach ($projects as $p) {
            $s = strtolower($p['status'] ?? 'active');
            if (isset($projectStats[$s])) $projectStats[$s]++;
            $totalBudget += (float)($p['budget'] ?? 0);
        }

        $this->render('reports/index', compact(
            'monthly', 'totalInvoiced', 'totalCollected', 'totalOutstanding',
            'bestMonth', 'clientTotals', 'projectStats', 'totalBudget'
        ));
    }
}
