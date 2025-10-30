<?php
require_once __DIR__ . '/includes/header.php';
$u = get_user();
if (!$u || ($u['role'] ?? 'user') !== 'user') {
    header('Location: ' . (($u && ($u['role'] ?? '') === 'admin') ? 'admin/index.php' : 'login.php'));
    exit();
}
$cartItems = products_from_cart();
$cartTotal = 0.0;
foreach ($cartItems as $it) { $cartTotal += $it['price'] * $it['qty']; }
// Orders
$userId = (int)$u['id'];
global $mysqli;
$stmt = $mysqli->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC');
$stmt->bind_param('i', $userId);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
function order_badge($status) {
    $cl = $status == 'confirmed' ? 'badge-green' : ($status == 'rejected' ? 'badge-red' : 'badge-blue');
    return '<span class="badge ' . $cl . '">' . ucfirst($status) . '</span>';
}
?>
<div class="account-main-center">
  <section class="section">
    <h2 class="section-title account-title">My Account</h2>

    <div class="card account-card">
      <h3 class="account-header">Welcome, <?php echo e($u['name']); ?>!</h3>
      <div style="margin-bottom:12px;color:var(--muted);">(<?php echo e($u['email']); ?>)</div>
    </div>

    <div class="card account-card">
      <h3 class="account-header">Your Shopping Cart</h3>
      <?php if (!$cartItems): ?>
        <p>Your cart is empty.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table>
            <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
              <tr>
                <td><?php echo e($item['name']); ?></td>
                <td>$<?php echo number_format((float)$item['price'], 2); ?></td>
                <td><?php echo (int)$item['qty']; ?></td>
                <td>$<?php echo number_format((float)$item['price'] * (int)$item['qty'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="cart-totaler">Total: $<?php echo number_format($cartTotal,2); ?></div>
        <div style="margin-top:14px;">
          <a class="btn btn-primary" href="cart.php">View/Edit Cart</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="card account-card">
      <h3 class="account-header">Your Orders</h3>
      <?php if (!$orders): ?>
        <p>No orders yet.</p>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <div class="order-block">
            <div class="order-head">
              <span class="order-number">Order #<?php echo (int)$order['id']; ?>, <?php echo date('M j, Y', strtotime($order['created_at'])); ?></span>
              <?php echo order_badge($order['status']); ?>
            </div>
            <div class="order-total">Total: $<?php echo number_format((float)$order['total'],2); ?></div>
            <?php
            $oi_stmt = $mysqli->prepare('SELECT oi.*, p.name FROM order_items oi LEFT JOIN products p ON oi.product_id=p.id WHERE oi.order_id=?');
            $oi_stmt->bind_param('i', $order['id']);
            $oi_stmt->execute();
            $items = $oi_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            ?>
            <div class="table-responsive"><table style="margin-top:6px;">
              <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
              <tbody>
              <?php foreach ($items as $it): ?>
                <tr>
                  <td><?php echo e($it['name'] ?? 'Deleted'); ?></td>
                  <td>$<?php echo number_format((float)$it['price'], 2); ?></td>
                  <td><?php echo (int)$it['quantity']; ?></td>
                  <td>$<?php echo number_format((float)$it['price'] * (int)$it['quantity'], 2); ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
<style>
.account-main-center { max-width: 680px; margin: 0 auto; padding: 20px 8px 40px; }
.account-title { font-size: 2.0rem; font-weight: 700; margin-bottom: 18px; text-align:center; }
.account-card {
  border-radius: 18px;
  box-shadow: 0 2.5px 14px 0 rgba(0,36,80,.06);
  padding: 24px 22px 18px 22px;
  margin-bottom: 24px;
  background: white;
  border: 1px solid #e6effa;
}
.account-header { font-size: 1.35rem; font-weight: 600; color: #1853A1; margin-bottom: 12px; letter-spacing:-0.5px; }
.cart-totaler { margin-top:16px; font-weight:700; font-size:1.1em; }
.order-block { margin-bottom:30px; padding-bottom:16px; border-bottom: 1px solid #e0e7ef; }
.order-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
.order-number { font-weight:600; }
.order-total { color:#234372; margin-bottom:5px; }
.badge-blue  { background:#e0f2fe; color:#0369a1; padding:2px 8px; border-radius:8px; font-size:13px; }
.badge-green { background:#dcfce7; color:#166534; padding:2px 8px; border-radius:8px; font-size:13px; }
.badge-red   { background:#fee2e2; color:#b91c1c; padding:2px 8px; border-radius:8px; font-size:13px; }
.table-responsive { overflow-x:auto; }
table { min-width:340px; border-collapse:collapse; }
td, th { padding:7px 7px 7px 0; }
@media (max-width:600px) {
  .account-main-center { padding: 12px 2vw 30px; }
  .account-title { font-size:1.2rem; }
  .account-card { padding:13px 4vw 13px 4vw; }
  table { font-size:95%; }
  .account-header { font-size:1rem; }
}
</style>