<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';

/*
|--------------------------------------------------------------------------
| 1. GET URL
|--------------------------------------------------------------------------
*/
$url = $_GET['url'] ?? 'auth/login';
$url = trim($url, '/');
$parts = array_values(array_filter(explode('/', $url)));

/*
|--------------------------------------------------------------------------
| 2. CONTROLLER + ACTION SAFETY
|--------------------------------------------------------------------------
*/
$controllerName = $parts[0] ?? 'auth';
$action         = $parts[1] ?? 'index';
$params         = array_slice($parts, 2);

$controller = ucfirst($controllerName) . 'Controller';

/*
|--------------------------------------------------------------------------
| 3. CONTROLLER FILE PATH
|--------------------------------------------------------------------------
*/
$file = __DIR__ . "/controllers/$controller.php";

if (!file_exists($file)) {
    http_response_code(404);
    exit("Controller not found: $controller");
}

require_once $file;

/*
|--------------------------------------------------------------------------
| 4. CLASS CHECK
|--------------------------------------------------------------------------
*/
if (!class_exists($controller)) {
    http_response_code(404);
    exit("Class not found: $controller");
}

/*
|--------------------------------------------------------------------------
| 5. CREATE CONTROLLER OBJECT
|--------------------------------------------------------------------------
*/
$obj = new $controller($conn);

/*
|--------------------------------------------------------------------------
| 6. METHOD CHECK (IMPORTANT FIX)
|--------------------------------------------------------------------------
*/
if (!method_exists($obj, $action)) {
    http_response_code(404);
    exit("Action not found: $action in $controller");
}

/*
|--------------------------------------------------------------------------
| 7. RUN CONTROLLER METHOD
|--------------------------------------------------------------------------
*/
call_user_func_array([$obj, $action], $params);