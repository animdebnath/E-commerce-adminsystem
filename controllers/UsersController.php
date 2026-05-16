<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class UsersController extends Controller {

    public function index() {
        require_admin();

        $q = $_GET['q'] ?? '';
        $role = $_GET['role'] ?? 'customer';

        if (!in_array($role, ['customer','delivery'], true)) {
            $role = 'customer';
        }

        $users = (new UserModel($this->db))->listByRole($role, $q);

        $this->view('users/index', [
            'pageTitle' => 'Users',
            'users' => $users,
            'q' => $q,
            'role' => $role
        ]);
    }

    public function save() {
        require_admin();

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role  = $_POST['role'] ?? 'customer';
        $pass  = $_POST['password'] ?? '';

        if (!in_array($role, ['customer','delivery'], true)) {
            $role = 'customer';
        }

        $errors = [];

        if ($name === '') $errors[] = 'Name is required';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
        if (strlen($pass) < 6) $errors[] = 'Password min 6 chars';

        $m = new UserModel($this->db);

        if (!$errors && $m->emailExists($email)) {
            $errors[] = 'Email already in use';
        }

        if (!empty($errors)) {
            flash_set('error', implode(', ', $errors));
            redirect('users');
        }

        $m->create($name, $email, $phone, $role, $pass);

        flash_set('success', 'User created');
        redirect('users');
    }

    public function delete($id) {
        require_admin();

        (new UserModel($this->db))->delete((int)$id);

        flash_set('success', 'User deleted');
        redirect('users');
    }

    public function setStatus($id) {
        require_admin();

        $status = $_GET['s'] ?? 'active';

        if (!in_array($status, ['active','inactive'], true)) {
            $status = 'active';
        }

        (new UserModel($this->db))->setStatus((int)$id, $status);

        flash_set('success', 'User updated');
        redirect('users');
    }
}