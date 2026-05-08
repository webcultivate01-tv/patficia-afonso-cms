<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controllers/Controller.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/DashboardController.php';
require_once __DIR__ . '/app/controllers/ClientController.php';
require_once __DIR__ . '/app/controllers/PaymentController.php';
require_once __DIR__ . '/app/controllers/ProjectController.php';
require_once __DIR__ . '/app/controllers/AdminController.php';
require_once __DIR__ . '/app/controllers/ServiceController.php';
require_once __DIR__ . '/app/controllers/BillController.php';
require_once __DIR__ . '/app/controllers/ReportsController.php';
require_once __DIR__ . '/app/controllers/QuotesController.php';
require_once __DIR__ . '/app/controllers/CalendarController.php';
require_once __DIR__ . '/app/controllers/SearchController.php';
require_once __DIR__ . '/app/controllers/ProfileController.php';
require_once __DIR__ . '/app/controllers/AgingController.php';
require_once __DIR__ . '/app/controllers/StatementController.php';
require_once __DIR__ . '/app/controllers/PortfolioController.php';
require_once __DIR__ . '/app/controllers/EnquiryController.php';

$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

// Home redirect
if ($page === 'home' || $page === '') {
    header('Location: index.html');
    exit;
}

// Auth routes (no login required)
if ($page === 'login') {
    $auth = new AuthController();
    $auth->login();
    exit;
}
if ($page === 'logout') {
    $auth = new AuthController();
    $auth->logout();
    exit;
}

// Public enquiry submission (no login required)
if ($page === 'enquiries' && $action === 'submit') {
    $enquiry = new EnquiryController();
    $enquiry->submit();
    exit;
}

// Guard all other pages
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php?page=login');
    exit;
}

$controllers = [
    'dashboard' => 'DashboardController',
    'clients'   => 'ClientController',
    'payments'  => 'PaymentController',
    'projects'  => 'ProjectController',
    'admins'    => 'AdminController',
    'services'  => 'ServiceController',
    'bills'     => 'BillController',
    'reports'   => 'ReportsController',
    'quotes'    => 'QuotesController',
    'calendar'  => 'CalendarController',
    'search'    => 'SearchController',
    'profile'   => 'ProfileController',
    'aging'     => 'AgingController',
    'statement' => 'StatementController',
    'portfolio' => 'PortfolioController',
    'enquiries' => 'EnquiryController',
];

if (!isset($controllers[$page])) {
    header('Location: index.html');
    exit;
}

$controller = new $controllers[$page]();

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
