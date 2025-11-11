<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php
cart_init();
file_put_contents(__DIR__.'/includes/cart_debug.log', "CART PAGE [".date('c')."] ".json_encode($_SESSION['cart'])."\n", FILE_APPEND);
if (is_post()) {
  foreach (($_POST['qty'] ?? []) as $id => $qty) { cart_set((int)$id, (int)$qty); }
  if (isset($_POST['remove'])) { cart_remove((int)$_POST['remove']); }
}
$items = products_from_cart();
$total = 0.0;
foreach ($items as $it) { $total += (float)$it['price'] * (int)$it['qty']; }
?>

<section class="section">
  <h2 class="section-title">Shopping Cart</h2>
  <?php if (!$items): ?>
    <p>Your cart is empty. <a href="/catalog.php">Go shopping</a>.</p>
  <?php else: ?>
  <form method="post">
    <table>
      <thead>
        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr>
      </thead>
      <tbody>
      <?php foreach ($items as $it): $sub = (float)$it['price'] * (int)$it['qty']; ?>
        <tr>
          <td><a href="<?php echo e(base_url('product.php?id='.(int)$it['id'])); ?>"><?php echo e($it['name']); ?></a></td>
          <td>$<?php echo number_format((float)$it['price'], 2); ?></td>
          <td><input type="number" min="0" name="qty[<?php echo (int)$it['id']; ?>]" value="<?php echo (int)$it['qty']; ?>" style="width:90px;"></td>
          <td>$<?php echo number_format($sub, 2); ?></td>
          <td>
            <button class="btn" name="remove" value="<?php echo (int)$it['id']; ?>">Remove</button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
      <button class="btn" type="submit">Update Cart</button>
      <div style="font-weight:700;">Total: $<?php echo number_format($total, 2); ?></div>
    </div>
  </form>
  <div style="margin-top:12px; display:flex; gap:8px; justify-content:flex-end;">
    <a class="btn" href="/catalog.php">Continue Shopping</a>
    <a class="btn btn-primary" href="<?php echo e(base_url('order.php')); ?>">Checkout</a>
  </div>
  <?php endif; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


