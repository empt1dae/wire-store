<?php
require_once __DIR__ . '/functions.php';

function require_login(): void {
    if (!get_user()) {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'] ?? '/';
        $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $loginPath = (substr($scriptDir, -6) === '/admin') ? '../login.php' : 'login.php';
        header('Location: ' . $loginPath);
        exit;
    }
}

?>


