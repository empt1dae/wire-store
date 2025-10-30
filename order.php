<?php require_once __DIR__ . '/includes/header.php'; require_once __DIR__ . '/includes/auth.php'; ?>
<?php
// Allow guest checkout for simplicity; if you want auth, uncomment:
// require_login();

$errors = [];
$ok = false;
$items = products_from_cart();
$total = 0.0; foreach ($items as $it) { $total += (float)$it['price'] * (int)$it['qty']; }

if (is_post()) {
  $name = trim($_POST['name'] ?? '');
  $address = trim($_POST['address'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $payment = trim($_POST['payment'] ?? 'card');
  if ($name === '') $errors[] = 'Name is required';
  if ($address === '') $errors[] = 'Address is required';
  if ($phone === '') $errors[] = 'Phone is required';
  if (!$items) $errors[] = 'Cart is empty';

  if (!$errors) {
    global $mysqli; $mysqli->begin_transaction();
    try {
      $userId = get_user()['id'] ?? null;
      $stmt = $mysqli->prepare('INSERT INTO orders (user_id, customer_name, address, phone, payment_method, total, status, created_at) VALUES (?,?,?,?,?,?,"new", NOW())');
      $stmt->bind_param('issssd', $userId, $name, $address, $phone, $payment, $total);
      $stmt->execute();
      $orderId = $stmt->insert_id;
      $oi = $mysqli->prepare('INSERT INTO order_items (order_id, product_id, price, quantity) VALUES (?,?,?,?)');
      foreach ($items as $it) {
        $pid = (int)$it['id']; $price = (float)$it['price']; $qty = (int)$it['qty'];
        $oi->bind_param('iidi', $orderId, $pid, $price, $qty);
        $oi->execute();
      }
      $mysqli->commit();
      $_SESSION['cart'] = [];
      $ok = true;
    } catch (Throwable $e) {
      $mysqli->rollback();
      $errors[] = 'Failed to place order.';
    }
  }
}
?>

<section class="section">
  <h2 class="section-title">Checkout</h2>
  <?php if ($ok): ?>
    <p>Thank you! Your order has been received. <a href="/index.php">Return home</a>.</p>
  <?php else: ?>
    <?php if ($errors): ?><div class="card" style="padding:12px; color:#b91c1c; border:1px solid #fecaca; background:#fef2f2; border-radius:12px; margin-bottom:12px;">
      <?php foreach ($errors as $e) echo '<div>'.e($e).'</div>'; ?>
    </div><?php endif; ?>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <form class="card form" method="post" style="padding:16px;">
        <div class="field">
          <label>Full name</label>
          <input required type="text" name="name" value="<?php echo e($_POST['name'] ?? ($u['name'] ?? '')); ?>">
        </div>
        <div class="field">
          <label>Address</label>
          <textarea required name="address"><?php echo e($_POST['address'] ?? ''); ?></textarea>
        </div>
        <div class="field">
          <label>Phone</label>
          <input required type="text" name="phone" value="<?php echo e($_POST['phone'] ?? ''); ?>">
        </div>
        <div class="field">
          <label>Payment method</label>
          <select name="payment">
            <option value="card">Card</option>
            <option value="cod">Cash on Delivery</option>
          </select>
        </div>
        <div style="display:flex; gap:8px;">
          <button class="btn btn-primary" type="submit">Confirm Order</button>
        </div>
      </form>
      <div class="card" style="padding:16px;">
        <strong>Order Summary</strong>
        <table style="margin-top:8px;">
          <tbody>
            <?php foreach ($items as $it): ?>
              <tr>
                <td><?php echo e($it['name']); ?> × <?php echo (int)$it['qty']; ?></td>
                <td style="text-align:right;">$<?php echo number_format((float)$it['price'] * (int)$it['qty'], 2); ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
              <td><strong>Total</strong></td>
              <td style="text-align:right;"><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


