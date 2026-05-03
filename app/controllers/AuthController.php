<?php
require_once __DIR__ . '/Controller.php';

class AuthController extends Controller {

    private function collection() {
        return Database::getInstance()->getCollection('admins');
    }

    private function seedDefaultAdmin(): void {
        $exists = $this->collection()->findOne(['email' => 'admin@patridesigns.com']);
        if (!$exists) {
            $this->collection()->insertOne([
                'name'       => 'Patricia Afonso',
                'email'      => 'admin@patridesigns.com',
                'password'   => password_hash('patricia2025', PASSWORD_BCRYPT),
                'role'       => 'superadmin',
                'created_at' => new MongoDB\BSON\UTCDateTime(),
            ]);
        }
    }

    public function login(): void {
        $this->seedDefaultAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim(strtolower($_POST['email']    ?? ''));
            $password = trim($_POST['password'] ?? '');

            $admin = $this->collection()->findOne(['email' => $email]);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id']        = (string) $admin['_id'];
                $_SESSION['admin_name']      = $admin['name'];
                $_SESSION['admin_email']     = $admin['email'];
                $_SESSION['admin_role']      = $admin['role'] ?? 'admin';
                header('Location: index.php?page=dashboard');
                exit;
            }

            $_SESSION['login_error'] = 'Invalid email or password.';
            header('Location: index.php?page=login');
            exit;
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        $this->render('auth/login', compact('error'), true);
    }

    public function logout(): void {
        session_destroy();
        header('Location: index.html');
        exit;
    }
}
