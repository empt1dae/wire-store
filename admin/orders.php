<?php require_once __DIR__ . '/../includes/header.php'; require_admin(); ?>
<?php
global $mysqli; $msg = '';
if (is_post()) {
  $id = (int)($_POST['id'] ?? 0);
  $status = $_POST['status'] ?? 'new';
  if (in_array($status, ['new','confirmed','rejected'], true)) {
    $stmt = $mysqli->prepare('UPDATE orders SET status=? WHERE id=?');
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
    $msg = 'Order updated';
  }
}

$rows = $mysqli->query('SELECT * FROM orders ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
?>

<section class="section">
  <h2 class="section-title">Orders</h2>
  <?php if ($msg): ?><div class="card" style="padding:12px; background:#ecfeff; border:1px solid #a5f3fc; border-radius:12px; margin-bottom:12px;"><?php echo e($msg); ?></div><?php endif; ?>
  <div class="card" style="padding:0; overflow:auto;">
    <table>
      <thead><tr><th>ID</th><th>Customer</th><th>Phone</th><th>Total</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td>#<?php echo (int)$r['id']; ?></td>
            <td><?php echo e($r['customer_name']); ?></td>
            <td><?php echo e($r['phone']); ?></td>
            <td>$<?php echo number_format((float)$r['total'], 2); ?></td>
            <td><?php echo e($r['status']); ?></td>
            <td><?php echo e($r['created_at']); ?></td>
            <td>
              <form method="post" style="display:flex; gap:6px; align-items:center;">
                <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                <select name="status">
                  <?php foreach (['new','confirmed','rejected'] as $s): ?>
                    <option <?php echo $r['status']===$s?'selected':''; ?> value="<?php echo e($s); ?>"><?php echo e(ucfirst($s)); ?></option>
                  <?php endforeach; ?>
                </select>
                <button class="btn" type="submit">Update</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


