<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Project.php';

class DashboardController extends Controller {
    public function index(): void {
        $db = Database::getInstance();

        $payments = $db->getCollection('payments')->find()->toArray();
        $projects = $db->getCollection('projects')->find()->toArray();

        $totalClients  = $db->getCollection('clients')->countDocuments();
        $totalProjects = count($projects);
        $totalRevenue  = array_sum(array_map(fn($p) => (float)($p['amount'] ?? 0), $payments));
        $totalCollected = array_sum(array_map(fn($p) => ($p['status'] ?? '') === 'paid' ? (float)($p['amount'] ?? 0) : 0, $payments));
        $totalOutstanding = array_sum(array_map(fn($p) => ($p['status'] ?? '') !== 'paid' ? (float)($p['remaining'] ?? $p['amount'] ?? 0) : 0, $payments));
        $pendingPayments = count(array_filter($payments, fn($p) => ($p['status'] ?? '') === 'pending'));
        $overduePayments = count(array_filter($payments, fn($p) => ($p['status'] ?? '') === 'overdue'));
        $activeProjects  = count(array_filter($projects, fn($p) => ($p['status'] ?? '') === 'active'));

        // Revenue by month (last 6 months) — from paid payments
        $monthlyRevenue = [];
        $monthLabels    = [];
        for ($i = 5; $i >= 0; $i--) {
            $ts    = strtotime("-{$i} months");
            $key   = date('Y-m', $ts);
            $monthLabels[]        = date('M Y', $ts);
            $monthlyRevenue[$key] = 0;
        }
        foreach ($payments as $p) {
            if (($p['status'] ?? '') !== 'paid') continue;
            $ts = null;
            if (!empty($p['created_at'])) {
                try { $ts = intdiv((int)(string)$p['created_at'], 1000); } catch (\Exception $e) {}
            }
            if (!$ts) continue;
            $key = date('Y-m', $ts);
            if (isset($monthlyRevenue[$key])) {
                $monthlyRevenue[$key] += (float)($p['amount'] ?? 0);
            }
        }

        // Payment status counts for doughnut
        $statusCounts = ['paid' => 0, 'pending' => 0, 'overdue' => 0];
        foreach ($payments as $p) {
            $s = strtolower($p['status'] ?? 'pending');
            if (isset($statusCounts[$s])) $statusCounts[$s]++;
        }

        // Project status counts
        $projectStatusCounts = ['active' => 0, 'completed' => 0, 'on-hold' => 0, 'cancelled' => 0];
        foreach ($projects as $p) {
            $s = strtolower($p['status'] ?? 'active');
            if (isset($projectStatusCounts[$s])) $projectStatusCounts[$s]++;
        }

        // Top 5 clients by total billed
        $clientTotals = [];
        foreach ($payments as $p) {
            $name = $p['client_name'] ?? 'Unknown';
            $clientTotals[$name] = ($clientTotals[$name] ?? 0) + (float)($p['amount'] ?? 0);
        }
        arsort($clientTotals);
        $topClients = array_slice($clientTotals, 0, 5, true);

        $recentClients  = $db->getCollection('clients')->find([], ['limit' => 5, 'sort' => ['created_at' => -1]])->toArray();
        $recentPayments = $db->getCollection('payments')->find([], ['limit' => 5, 'sort' => ['created_at' => -1]])->toArray();
        $recentProjects = $db->getCollection('projects')->find([], ['limit' => 5, 'sort' => ['created_at' => -1]])->toArray();

        $this->render('dashboard/index', compact(
            'totalClients', 'totalProjects', 'totalRevenue', 'totalCollected',
            'totalOutstanding', 'pendingPayments', 'overduePayments', 'activeProjects',
            'monthLabels', 'monthlyRevenue', 'statusCounts', 'projectStatusCounts',
            'topClients', 'recentClients', 'recentPayments', 'recentProjects'
        ));
    }
}
