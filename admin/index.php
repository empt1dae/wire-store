<?php require_once __DIR__ . '/../includes/header.php'; require_admin(); ?>
<?php
// Stats
global $mysqli;
$orders = $mysqli->query('SELECT COUNT(*) c, COALESCE(SUM(total),0) revenue FROM orders')->fetch_assoc();
$products = $mysqli->query('SELECT COUNT(*) c FROM products')->fetch_assoc();
$users = $mysqli->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch_assoc();
?>

<section class="section">
  <h2 class="section-title">Admin Dashboard</h2>
  <div class="advantages" style="margin-bottom:16px;">
    <div class="adv-item"><div class="adv-title">Orders</div><div class="adv-text"><?php echo (int)$orders['c']; ?></div></div>
    <div class="adv-item"><div class="adv-title">Revenue</div><div class="adv-text">$<?php echo number_format((float)$orders['revenue'],2); ?></div></div>
    <div class="adv-item"><div class="adv-title">Products</div><div class="adv-text"><?php echo (int)$products['c']; ?></div></div>
    <div class="adv-item"><div class="adv-title">Users</div><div class="adv-text"><?php echo (int)$users['c']; ?></div></div>
  </div>
  <div style="display:flex; gap:8px;">
    <a class="btn" href="products.php">Manage Products</a>
    <a class="btn" href="orders.php">Manage Orders</a>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


