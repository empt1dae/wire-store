<?php
require_once __DIR__ . '/db.php';

function get_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function require_admin(): void {
    $u = get_user();
    if (!$u || ($u['role'] ?? 'user') !== 'admin') {
        $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $loginPath = (substr($scriptDir, -6) === '/admin') ? '../login.php' : 'login.php';
        header('Location: ' . $loginPath);
        exit;
    }
}

function cart_init(): void {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = []; // id => qty
}

function cart_add(int $id, int $qty = 1): void {
    cart_init();
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + max(1, $qty);
}

function cart_set(int $id, int $qty): void {
    cart_init();
    if ($qty <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id] = $qty;
}

function cart_remove(int $id): void {
    cart_init();
    unset($_SESSION['cart'][$id]);
}

function cart_count(): int {
    cart_init();
    return array_sum($_SESSION['cart']);
}

function fetch_products(?string $search = null, ?string $category = null, ?string $sort = null): array {
    global $mysqli;
    $sql = 'SELECT * FROM products WHERE 1';
    $params = [];
    if ($search) { $sql .= ' AND name LIKE ?'; $params[] = "%$search%"; }
    if ($category && in_array($category, ['keyboards','mice','headphones','accessories'])) { $sql .= ' AND category = ?'; $params[] = $category; }
    if ($sort === 'price_asc') $sql .= ' ORDER BY price ASC';
    elseif ($sort === 'price_desc') $sql .= ' ORDER BY price DESC';
    elseif ($sort === 'popular') $sql .= ' ORDER BY sold DESC, id DESC';
    else $sql .= ' ORDER BY id DESC';

    $stmt = $mysqli->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}

function fetch_product(int $id): ?array {
    global $mysqli;
    $stmt = $mysqli->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res ?: null;
}

function products_from_cart(): array {
    cart_init();
    if (!$_SESSION['cart']) return [];
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // attach qty
    foreach ($result as &$p) { $p['qty'] = $_SESSION['cart'][$p['id']] ?? 0; }
    return $result;
}

?>


