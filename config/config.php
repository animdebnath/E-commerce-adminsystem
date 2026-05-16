<?php
// config/config.php — global app config
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auto-detect base URL so the project works in any htdocs subfolder
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Trim trailing /public if you reorganize later — for now we sit at project root
define('BASE_URL', rtrim($scriptDir, '/'));

define('APP_NAME', 'ShopAdmin');
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
