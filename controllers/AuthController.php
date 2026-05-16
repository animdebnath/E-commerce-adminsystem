<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {
    public function login() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $pass  = $_POST['password'] ?? '';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
            if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
            if (!$errors) {
                $m = new UserModel($this->db);
                $u = $m->findByEmail($email);
                if ($u && password_verify($pass, $u['password']) && $u['role'] === 'admin' && $u['status'] === 'active') {
                    session_regenerate_id(true);
                    $_SESSION['user_id']    = $u['id'];
                    $_SESSION['user_name']  = $u['name'];
                    $_SESSION['user_email'] = $u['email'];
                    $_SESSION['user_role']  = $u['role'];
                    log_activity($this->db, $u['email'], 'Logged in');
                    redirect('dashboard');
                }
                $errors[] = 'Invalid credentials or not an admin account.';
            }
        }
        $this->viewBare('auth/login', ['errors' => $errors]);
    }
    public function logout() {
        logout_user();
        redirect('auth/login');
    }
}
