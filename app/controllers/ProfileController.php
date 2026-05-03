<?php
require_once __DIR__ . '/Controller.php';

class ProfileController extends Controller {
    private function col() {
        return Database::getInstance()->getCollection('admins');
    }

    public function index(): void {
        $admin = $this->col()->findOne(['_id' => new MongoDB\BSON\ObjectId($_SESSION['admin_id'])]);
        $this->render('profile/index', ['admin' => $admin, 'success' => $_GET['success'] ?? null, 'error' => null]);
    }

    public function update(): void {
        $id    = $_SESSION['admin_id'];
        $name  = trim($_POST['name'] ?? '');
        $email = trim(strtolower($_POST['email'] ?? ''));

        if (!$name || !$email) {
            $admin = $this->col()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            $this->render('profile/index', ['admin' => $admin, 'success' => null, 'error' => 'Name and email are required.']);
            return;
        }

        $data = ['name' => $name, 'email' => $email];

        // Password change (optional)
        $newPass = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if ($newPass !== '') {
            if (strlen($newPass) < 6) {
                $admin = $this->col()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
                $this->render('profile/index', ['admin' => $admin, 'success' => null, 'error' => 'Password must be at least 6 characters.']);
                return;
            }
            if ($newPass !== $confirm) {
                $admin = $this->col()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
                $this->render('profile/index', ['admin' => $admin, 'success' => null, 'error' => 'Passwords do not match.']);
                return;
            }
            $data['password'] = password_hash($newPass, PASSWORD_BCRYPT);
        }

        $this->col()->updateOne(['_id' => new MongoDB\BSON\ObjectId($id)], ['$set' => $data]);
        $_SESSION['admin_name']  = $name;
        $_SESSION['admin_email'] = $email;
        header('Location: index.php?page=profile&success=1');
    }
}
