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
    
    $uploaded = [];
    if (!empty($_FILES['images']['name'][0] ?? null)) {
      $uploadDir = dirname(__DIR__) . '/assets/uploads/';
      if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
      $names = $_FILES['images']['name'];
      $tmps = $_FILES['images']['tmp_name'];
      $errs = $_FILES['images']['error'];
      $types = $_FILES['images']['type'];
      foreach ($names as $i => $nm) {
        if (($errs[$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
          $ext = pathinfo($nm, PATHINFO_EXTENSION);
          $ext = preg_replace('/[^a-zA-Z0-9]/','',$ext);
          $safe = preg_replace('/[^a-zA-Z0-9_-]/','_', pathinfo($nm, PATHINFO_FILENAME));
          $fname = $safe . '-' . uniqid() . ($ext?'.'.$ext:'');
          $dest = $uploadDir . $fname;
          if (@move_uploaded_file($tmps[$i], $dest)) {
            $uploaded[] = 'assets/uploads/' . $fname; 
          }
        }
      }
    }
    
    if ($uploaded) {
      $pieces = preg_split('/[\n,]+/', $image);
      $pieces = array_filter(array_map('trim', $pieces));
      $image = implode(',', array_merge($pieces, $uploaded));
    }
    $description = trim($_POST['description'] ?? '');
    $specs = trim($_POST['specs'] ?? '');
    if ($action === 'create') {
      $stmt = $mysqli->prepare('INSERT INTO products (name, category, price, image, description, specs, sold, created_at) VALUES (?,?,?,?,?,?,0,NOW())');
      $stmt->bind_param('ssdsss', $name, $category, $price, $image, $description, $specs);
      $stmt->execute();
      $msg = 'Product created';
      $_SESSION['admin_notify'] = ['type' => 'success', 'message' => 'Product created successfully!'];
    } else {
      $stmt = $mysqli->prepare('UPDATE products SET name=?, category=?, price=?, image=?, description=?, specs=? WHERE id=?');
      $stmt->bind_param('ssdsssi', $name, $category, $price, $image, $description, $specs, $id);
      $stmt->execute();
      $msg = 'Product updated';
      $_SESSION['admin_notify'] = ['type' => 'success', 'message' => 'Product updated successfully!'];
    }
  }
  if (($_POST['action'] ?? '') === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $mysqli->prepare('DELETE FROM products WHERE id=?')->bind_param('i', $id)->execute();
    $msg = 'Product deleted';
    $_SESSION['admin_notify'] = ['type' => 'success', 'message' => 'Product deleted successfully!'];
  }
}
$notify = $_SESSION['admin_notify'] ?? null;
if ($notify) unset($_SESSION['admin_notify']);

$rows = $mysqli->query('SELECT * FROM products ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC);
$edit = null; if (isset($_GET['edit'])) { $edit = fetch_product((int)$_GET['edit']); }
?>

<section class="section">
  <h2 class="section-title">Products</h2>
  <?php if ($msg): ?><div class="card" style="padding:12px; background:#ecfeff; border:1px solid #a5f3fc; border-radius:12px; margin-bottom:12px;"><?php echo e($msg); ?></div><?php endif; ?>

  <div class="card" style="padding:16px; margin-bottom:16px;">
    <form method="post" class="form" enctype="multipart/form-data" id="prodForm">
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
      <?php if ($edit && !empty($edit['image'])): ?>
        <div class="field"><label>Current Images</label>
          <div id="admin-imgs-list" style="display:flex; gap:9px; flex-wrap:wrap;margin-bottom:6px;">
            <?php 
              $arr = preg_split('/[\n,]+/', trim($edit['image']));
              foreach ($arr as $idx=>$img) { $img = trim($img); if($img): ?>
              <div class="admin-img-thumb" data-path="<?php echo e($img); ?>" style="position:relative;display:inline-block;">
                <img src="<?php echo e(preg_match('~^https?://~',$img) ? $img : base_url($img)); ?>" style="width:64px;height:64px;object-fit:cover;border-radius:7px;border:1.5px solid #c8d8ef;">
                <button type="button" class="delimg-btn" style="position:absolute;top:-7px;right:-7px;background:#fff2;border-radius:50%;border:none;color:#d71c1c;font-size:18px;cursor:pointer;" aria-label="Remove image" onclick="removeImg('<?php echo e($img); ?>')">×</button>
              </div>
            <?php endif; } ?>
          </div>
          <input type="hidden" name="image" id="imageField" value="<?php echo e($edit['image']); ?>">
          <small style="color:#64748b;">Click × to remove an existing image from this product.</small>
        </div>
      <?php endif; ?>
      <div class="field"><label>Images</label>
        <input type="text" name="image" placeholder="URLs or relative paths, comma or newline separated" value="<?php echo e($edit['image'] ?? ''); ?>">
        <small style="color:#64748b;">You can also upload files below; uploaded paths will be saved automatically.</small>
        <input type="file" name="images[]" multiple accept="image/*">
      </div>
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
<?php if ($notify): ?>
<script type="module">
  import { showToast } from '<?php echo e(base_url('assets/js/main.js')); ?>';
  showToast('<?php echo e($notify['message']); ?>', '<?php echo e($notify['type']); ?>');
</script>
<?php endif; ?>

<script>
function removeImg(path) {
  const target = document.querySelector('.admin-img-thumb[data-path="'+path.replace(/'/g,"&#39;")+'"]');
  if (target) target.remove();
  let imgs = [];
  document.querySelectorAll('.admin-img-thumb').forEach(function(div){ imgs.push(div.getAttribute('data-path')); });
  document.getElementById('imageField').value = imgs.join(',');
}
</script>


