<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'wire';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    http_response_code(500);
    die('Database connection failed');
}

$mysqli->set_charset('utf8mb4');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'; }
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }


function base_url(string $path = ''): string {
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
   
    if (substr($scriptDir, -6) === '/admin') {
        $base = rtrim(substr($scriptDir, 0, -6), '/');
    } else {
        $base = $scriptDir;
    }
    $path = ltrim($path, '/');
    return ($base ? $base : '') . ($path ? '/' . $path : '');
}
?>


