<?php
header('Content-Type: application/json');
require_once __DIR__ . '/functions.php';

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 1);

try {
    if ($action === 'add' && $id > 0) {
        cart_add($id, max(1, $qty));
        file_put_contents(__DIR__.'/cart_debug.log', "API [".date('c')."] ".json_encode($_SESSION['cart'])."\n", FILE_APPEND);
        echo json_encode(['success' => true, 'count' => cart_count()]);
        exit;
    }
    if ($action === 'set' && $id > 0) {
        cart_set($id, $qty);
        file_put_contents(__DIR__.'/cart_debug.log', "API [".date('c')."] ".json_encode($_SESSION['cart'])."\n", FILE_APPEND);
        echo json_encode(['success' => true, 'count' => cart_count()]);
        exit;
    }
    if ($action === 'remove' && $id > 0) {
        cart_remove($id);
        file_put_contents(__DIR__.'/cart_debug.log', "API [".date('c')."] ".json_encode($_SESSION['cart'])."\n", FILE_APPEND);
        echo json_encode(['success' => true, 'count' => cart_count()]);
        exit;
    }
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error']);
}


