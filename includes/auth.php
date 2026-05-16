<?php
// includes/auth.php — session-based auth + role guard
require_once __DIR__ . '/../config/config.php';

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function current_user() {
    return [
        'id'    => $_SESSION['user_id']    ?? null,
        'name'  => $_SESSION['user_name']  ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'role'  => $_SESSION['user_role']  ?? '',
    ];
}

// Require admin or redirect to login
function require_admin() {
    if (!is_logged_in() || ($_SESSION['user_role'] ?? '') !== 'admin') {
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }
}

function logout_user() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
