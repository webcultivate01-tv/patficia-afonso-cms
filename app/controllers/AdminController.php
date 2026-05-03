<?php
require_once __DIR__ . '/Controller.php';

class AdminController extends Controller {

    private function collection() {
        return Database::getInstance()->getCollection('admins');
    }

    public function index(): void {
        $admins = $this->collection()->find([], ['sort' => ['created_at' => -1]])->toArray();
        $this->render('admins/index', compact('admins'));
    }

    public function create(): void {
        $this->render('admins/form', ['admin' => null, 'action' => 'store', 'error' => null]);
    }

    public function store(): void {
        $email = trim(strtolower($_POST['email'] ?? ''));
        $name  = trim($_POST['name'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $role  = $_POST['role'] ?? 'admin';

        if (!$email || !$name || !$pass) {
            $this->render('admins/form', ['admin' => null, 'action' => 'store', 'error' => 'All fields are required.']);
            return;
        }

        $exists = $this->collection()->findOne(['email' => $email]);
        if ($exists) {
            $this->render('admins/form', ['admin' => null, 'action' => 'store', 'error' => 'Email already exists.']);
            return;
        }

        $this->collection()->insertOne([
            'name'       => $name,
            'email'      => $email,
            'password'   => password_hash($pass, PASSWORD_BCRYPT),
            'role'       => $role,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ]);

        header('Location: index.php?page=admins&success=created');
        exit;
    }

    public function edit(): void {
        $admin = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($_GET['id'])]);
        $this->render('admins/form', ['admin' => $admin, 'action' => 'update', 'error' => null]);
    }

    public function update(): void {
        $id    = $_POST['id'] ?? '';
        $email = trim(strtolower($_POST['email'] ?? ''));
        $name  = trim($_POST['name'] ?? '');
        $role  = $_POST['role'] ?? 'admin';

        if (!$id || !$email || !$name) {
            $admin = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            $this->render('admins/form', ['admin' => $admin, 'action' => 'update', 'error' => 'All fields are required.']);
            return;
        }

        $duplicate = $this->collection()->findOne([
            'email' => $email,
            '_id'   => ['$ne' => new MongoDB\BSON\ObjectId($id)],
        ]);
        if ($duplicate) {
            $admin = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            $this->render('admins/form', ['admin' => $admin, 'action' => 'update', 'error' => 'Email already in use.']);
            return;
        }

        $this->collection()->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['name' => $name, 'email' => $email, 'role' => $role]]
        );

        header('Location: index.php?page=admins&success=updated');
        exit;
    }

    public function delete(): void {
        $id = $_GET['id'] ?? '';
        // Prevent deleting yourself
        if ($id && ($_SESSION['admin_id'] ?? '') !== $id) {
            $this->collection()->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        }
        header('Location: index.php?page=admins&success=deleted');
        exit;
    }

    public function password(): void {
        $id    = $_GET['id'] ?? $_POST['id'] ?? '';
        $admin = $this->collection()->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPass    = $_POST['password']         ?? '';
            $confirmPass = $_POST['password_confirm'] ?? '';

            if (!$newPass || strlen($newPass) < 6) {
                $this->render('admins/password', ['admin' => $admin, 'error' => 'Password must be at least 6 characters.']);
                return;
            }
            if ($newPass !== $confirmPass) {
                $this->render('admins/password', ['admin' => $admin, 'error' => 'Passwords do not match.']);
                return;
            }

            $this->collection()->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($id)],
                ['$set' => ['password' => password_hash($newPass, PASSWORD_BCRYPT)]]
            );

            header('Location: index.php?page=admins&success=password');
            exit;
        }

        $this->render('admins/password', ['admin' => $admin, 'error' => null]);
    }
}
