<?php
// includes/helpers.php — common helpers

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function url($path = '') {
    return BASE_URL . '/index.php?url=' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

function flash_set($key, $msg) {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][$key] = $msg;
}

function flash_get($key) {
    if (!empty($_SESSION['flash'][$key])) {
        $m = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $m;
    }
    return null;
}

function log_activity($conn, $actor, $action) {
    $stmt = $conn->prepare("INSERT INTO activity_log (actor, action) VALUES (?, ?)");
    $stmt->bind_param('ss', $actor, $action);
    $stmt->execute();
    $stmt->close();
}

// Validate uploaded image: returns saved filename or null
function save_uploaded_image($field, $subdir = 'products') {

    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'webp' => 'image/webp'
    ];

    $info = pathinfo($_FILES[$field]['name']);
    $ext = strtolower($info['extension'] ?? '');

    if (!isset($allowed[$ext])) return null;
    if ($_FILES[$field]['size'] > 2 * 1024 * 1024) return null;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES[$field]['tmp_name']);
    finfo_close($finfo);

    if ($mime !== $allowed[$ext]) return null;

    $name = uniqid('img_', true) . '.' . $ext;

    $baseDir = defined('UPLOAD_DIR') ? UPLOAD_DIR : __DIR__ . '/../uploads/';
    $dir = rtrim($baseDir, '/') . '/' . $subdir;

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name)) {
        return null;
    }

    return $subdir . '/' . $name;
}