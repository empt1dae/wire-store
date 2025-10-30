<?php require_once __DIR__ . '/../includes/header.php'; require_admin(); ?>
<?php
global $mysqli; $msg = '';

if (is_post()) {
  $action = $_POST['action'] ?? '';
  if ($action === 'create' || $action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $specs = trim($_POST['specs'] ?? '');
    if ($action === 'create') {
      $stmt = $mysqli->prepare('INSERT INTO products (name, category, price, image, description, specs, sold, created_at) VALUES (?,?,?,?,?,?,0,NOW())');
      $stmt->bind_param('ssdsss', $name, $category, $price, $image, $description, $specs);
      $stmt->execute();
      $msg = 'Product created';
    } else {
      $stmt = $mysqli->prepare('UPDATE products SET name=?, category=?, price=?, image=?, description=?, specs=? WHERE id=?');
      $stmt->bind_param('ssdsssi', $name, $category, $price, $image, $description, $specs, $id);
      $stmt->execute();
      $msg = 'Product updated';
    }
  }
  if (($_POST['action'] ?? '') === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $mysqli->prepare('DELETE FROM products WHERE id=?')->bind_param('i', $id)->execute();
    $msg = 'Product deleted';
  }
}

$rows = $mysqli->query('SELECT * FROM products ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
$edit = null; if (isset($_GET['edit'])) { $edit = fetch_product((int)$_GET['edit']); }
?>

<section class="section">
  <h2 class="section-title">Products</h2>
  <?php if ($msg): ?><div class="card" style="padding:12px; background:#ecfeff; border:1px solid #a5f3fc; border-radius:12px; margin-bottom:12px;"><?php echo e($msg); ?></div><?php endif; ?>

  <div class="card" style="padding:16px; margin-bottom:16px;">
    <form method="post" class="form">
      <input type="hidden" name="action" value="<?php echo $edit?'update':'create'; ?>">
      <input type="hidden" name="id" value="<?php echo (int)($edit['id'] ?? 0); ?>">
      <div class="field"><label>Name</label><input required type="text" name="name" value="<?php echo e($edit['name'] ?? ''); ?>"></div>
      <div class="field"><label>Category</label>
        <select name="category">
          <?php foreach (['keyboards','mice','headphones','accessories'] as $c): ?>
            <option <?php echo (($edit['category'] ?? '')===$c)?'selected':''; ?> value="<?php echo e($c); ?>"><?php echo e(ucfirst($c)); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Price</label><input required step="0.01" type="number" name="price" value="<?php echo e($edit['price'] ?? '0'); ?>"></div>
      <div class="field"><label>Image URL</label><input type="text" name="image" value="<?php echo e($edit['image'] ?? ''); ?>"></div>
      <div class="field"><label>Description</label><textarea name="description"><?php echo e($edit['description'] ?? ''); ?></textarea></div>
      <div class="field"><label>Specs</label><textarea name="specs"><?php echo e($edit['specs'] ?? ''); ?></textarea></div>
      <div><button class="btn btn-primary" type="submit"><?php echo $edit?'Update':'Create'; ?></button> <?php if ($edit): ?><a class="btn" href="products.php">Clear</a><?php endif; ?></div>
    </form>
  </div>

  <div class="card" style="padding:0; overflow:auto;">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Sold</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?php echo (int)$r['id']; ?></td>
            <td><?php echo e($r['name']); ?></td>
            <td><?php echo e($r['category']); ?></td>
            <td>$<?php echo number_format((float)$r['price'],2); ?></td>
            <td><?php echo (int)$r['sold']; ?></td>
            <td style="display:flex; gap:6px;">
              <a class="btn" href="products.php?edit=<?php echo (int)$r['id']; ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete this product?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                <button class="btn" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


